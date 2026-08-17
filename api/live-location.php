<?php
require_once __DIR__ . '/_common.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $busId = (int)($_GET['bus_id'] ?? 0);
    $sql = "SELECT ll.id,ll.bus_id,ll.route_id,ll.latitude,ll.longitude,ll.status,ll.updated_at,
                   b.bus_number,b.bus_type,
                   r.route_code,r.route_name,r.starting_point,r.ending_point,
                   u.name AS driver_name,
                   t.status AS trip_status
            FROM live_locations ll
            JOIN (SELECT bus_id, MAX(id) AS latest_id FROM live_locations GROUP BY bus_id) latest ON latest.latest_id=ll.id
            JOIN buses b ON b.id=ll.bus_id
            JOIN routes r ON r.id=ll.route_id
            LEFT JOIN driver_assignments da ON da.bus_id=ll.bus_id AND da.route_id=ll.route_id AND da.status='active'
            LEFT JOIN users u ON u.id=da.driver_id
            LEFT JOIN trips t ON t.bus_id=ll.bus_id AND t.route_id=ll.route_id AND t.status='active'
            WHERE b.status <> 'inactive'";
    $params = [];
    if ($busId > 0) { $sql .= " AND ll.bus_id=?"; $params[] = $busId; }
    $sql .= " ORDER BY b.bus_number";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $locations = $stmt->fetchAll();

    $routeIds = array_values(array_unique(array_map(fn($x) => (int)$x['route_id'], $locations)));
    $stopsByRoute = [];
    if ($routeIds) {
        $placeholders = implode(',', array_fill(0, count($routeIds), '?'));
        $stmt = $pdo->prepare("SELECT route_id,id,stop_name,stop_order,latitude,longitude FROM stops WHERE route_id IN ($placeholders) ORDER BY route_id,stop_order");
        $stmt->execute($routeIds);
        foreach ($stmt->fetchAll() as $stop) $stopsByRoute[(int)$stop['route_id']][] = $stop;
    }

    foreach ($locations as &$loc) {
        $loc['latitude'] = (float)$loc['latitude'];
        $loc['longitude'] = (float)$loc['longitude'];
        $loc['stops'] = $stopsByRoute[(int)$loc['route_id']] ?? [];
    }
    unset($loc);

    jsonResponse(['success'=>true,'locations'=>$locations,'server_time'=>date('c')]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);

$user = requireDriverJson();
$data = requestJson();
$busId = (int)($data['bus_id'] ?? 0);
$routeId = (int)($data['route_id'] ?? 0);
$lat = $data['latitude'] ?? null;
$lng = $data['longitude'] ?? null;
$status = trim((string)($data['status'] ?? 'on_route'));

if ($busId < 1 || $routeId < 1 || !validCoordinate($lat,$lng)) {
    jsonResponse(['success'=>false,'message'=>'Valid bus, route, latitude and longitude are required.'],422);
}
if (!in_array($status,['on_route','stopped','offline','emergency'],true)) $status='on_route';

$stmt = $pdo->prepare("SELECT da.bus_id,da.route_id FROM driver_assignments da WHERE da.driver_id=? AND da.bus_id=? AND da.route_id=? AND da.status='active' LIMIT 1");
$stmt->execute([(int)$user['id'],$busId,$routeId]);
if (!$stmt->fetch()) jsonResponse(['success'=>false,'message'=>'This bus and route are not assigned to you.'],403);

$stmt = $pdo->prepare("SELECT id FROM trips WHERE driver_id=? AND bus_id=? AND route_id=? AND status='active' ORDER BY id DESC LIMIT 1");
$stmt->execute([(int)$user['id'],$busId,$routeId]);
if (!$stmt->fetch()) jsonResponse(['success'=>false,'message'=>'Start an active trip before sending a location update.'],409);

$stmt = $pdo->prepare("INSERT INTO live_locations (bus_id,route_id,latitude,longitude,status) VALUES (?,?,?,?,?)");
$stmt->execute([$busId,$routeId,(float)$lat,(float)$lng,$status]);
jsonResponse(['success'=>true,'message'=>'Location updated successfully.','updated_at'=>date('c')]);
?>
