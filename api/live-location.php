<?php
require_once __DIR__ . '/_common.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $busId = (int)($_GET['bus_id'] ?? 0);
    $sql = "SELECT ll.id,ll.bus_id,ll.route_id,ll.latitude,ll.longitude,ll.accuracy,
                   COALESCE(ll.last_updated,ll.updated_at) AS last_updated,
                   ll.updated_at,ll.status,
                   b.bus_number,b.bus_type,b.capacity,
                   (SELECT COUNT(*) FROM bus_occupancy bo WHERE bo.bus_id=b.id AND bo.exited_at IS NULL) AS passengers,
                   r.route_code,r.route_name,r.starting_point,r.ending_point,
                   u.name AS driver_name,
                   t.status AS trip_status
            FROM live_locations ll
            JOIN (SELECT bus_id, MAX(id) AS latest_id FROM live_locations GROUP BY bus_id) latest
              ON latest.latest_id=ll.id
            JOIN buses b ON b.id=ll.bus_id
            JOIN routes r ON r.id=ll.route_id
            LEFT JOIN driver_assignments da
              ON da.bus_id=ll.bus_id AND da.route_id=ll.route_id AND da.status='active'
            LEFT JOIN users u ON u.id=da.driver_id
            LEFT JOIN trips t
              ON t.bus_id=ll.bus_id AND t.route_id=ll.route_id AND t.status='active'
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
        $stmt = $pdo->prepare("SELECT route_id,id,stop_name,stop_order,latitude,longitude
                               FROM stops WHERE route_id IN ($placeholders) ORDER BY route_id,stop_order");
        $stmt->execute($routeIds);
        foreach ($stmt->fetchAll() as $stop) $stopsByRoute[(int)$stop['route_id']][] = $stop;
    }

    foreach ($locations as &$loc) {
        $loc['latitude'] = (float)$loc['latitude'];
        $loc['longitude'] = (float)$loc['longitude'];
        $loc['accuracy'] = $loc['accuracy'] !== null ? (float)$loc['accuracy'] : null;
        $loc['capacity'] = (int)$loc['capacity'];
        $loc['passengers'] = (int)$loc['passengers'];
        $pct = $loc['capacity'] > 0 ? min(100,(int)round(($loc['passengers']/$loc['capacity'])*100)) : 0;
        $loc['occupancy_percentage'] = $pct;
        $loc['density'] = $pct < 50 ? 'LOW' : ($pct < 80 ? 'MEDIUM' : 'HIGH');
        $loc['stops'] = $stopsByRoute[(int)$loc['route_id']] ?? [];
    }
    unset($loc);

    jsonResponse(['success'=>true,'locations'=>$locations,'server_time'=>date('c')]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
}

$user = requireDriverJson();
$data = requestJson();
$busId = (int)($data['bus_id'] ?? 0);
$routeId = (int)($data['route_id'] ?? 0);
$lat = $data['latitude'] ?? null;
$lng = $data['longitude'] ?? null;
$accuracy = $data['accuracy'] ?? null;
$status = trim((string)($data['status'] ?? 'on_route'));

if ($busId < 1 || $routeId < 1 || !validCoordinate($lat,$lng)) {
    jsonResponse(['success'=>false,'message'=>'Valid bus, route, latitude and longitude are required.'],422);
}
if (!in_array($status,['on_route','stopped','offline','emergency'],true)) $status='on_route';
if ($accuracy !== null && (!is_numeric($accuracy) || (float)$accuracy < 0 || (float)$accuracy > 100000)) {
    jsonResponse(['success'=>false,'message'=>'Invalid GPS accuracy value.'],422);
}
$accuracy = $accuracy === null ? null : (float)$accuracy;

$stmt = $pdo->prepare("SELECT da.bus_id,da.route_id
                       FROM driver_assignments da
                       WHERE da.driver_id=? AND da.bus_id=? AND da.route_id=? AND da.status='active' LIMIT 1");
$stmt->execute([(int)$user['id'],$busId,$routeId]);
if (!$stmt->fetch()) {
    jsonResponse(['success'=>false,'message'=>'This bus and route are not assigned to you.'],403);
}

$stmt = $pdo->prepare("SELECT id FROM trips
                       WHERE driver_id=? AND bus_id=? AND route_id=? AND status='active'
                       ORDER BY id DESC LIMIT 1");
$stmt->execute([(int)$user['id'],$busId,$routeId]);
if (!$stmt->fetch()) {
    jsonResponse(['success'=>false,'message'=>'Start an active trip before sending a GPS location.'],409);
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("SELECT id FROM live_locations WHERE bus_id=? ORDER BY id DESC LIMIT 1 FOR UPDATE");
    $stmt->execute([$busId]);
    $locationId = $stmt->fetchColumn();

    if ($locationId) {
        $stmt = $pdo->prepare("UPDATE live_locations
                               SET route_id=?,latitude=?,longitude=?,accuracy=?,status=?,
                                   last_updated=CURRENT_TIMESTAMP,updated_at=CURRENT_TIMESTAMP
                               WHERE id=?");
        $stmt->execute([$routeId,(float)$lat,(float)$lng,$accuracy,$status,(int)$locationId]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO live_locations
                               (bus_id,route_id,latitude,longitude,accuracy,status,last_updated)
                               VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP)");
        $stmt->execute([$busId,$routeId,(float)$lat,(float)$lng,$accuracy,$status]);
    }
    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    jsonResponse(['success'=>false,'message'=>'Could not save the GPS location.'],500);
}

jsonResponse([
    'success'=>true,
    'message'=>'Real GPS location updated successfully.',
    'updated_at'=>date('c'),
    'accuracy'=>$accuracy
]);
?>
