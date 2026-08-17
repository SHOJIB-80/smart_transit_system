<?php
require_once __DIR__ . '/_common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
$user = requireDriverJson();
$data = requestJson();
$action = $data['action'] ?? '';

$stmt = $pdo->prepare("SELECT da.bus_id,da.route_id,b.bus_number,r.route_code,r.route_name FROM driver_assignments da JOIN buses b ON b.id=da.bus_id JOIN routes r ON r.id=da.route_id WHERE da.driver_id=? AND da.status='active' LIMIT 1");
$stmt->execute([(int)$user['id']]);
$assignment = $stmt->fetch();
if (!$assignment) jsonResponse(['success'=>false,'message'=>'No active bus and route assignment found.'],409);

if ($action === 'start') {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("SELECT id FROM trips WHERE driver_id=? AND status='active' LIMIT 1 FOR UPDATE");
        $stmt->execute([(int)$user['id']]);
        if ($stmt->fetch()) { $pdo->rollBack(); jsonResponse(['success'=>false,'message'=>'You already have an active trip.'],409); }

        $stmt = $pdo->prepare("SELECT id FROM trips WHERE bus_id=? AND status='active' LIMIT 1 FOR UPDATE");
        $stmt->execute([(int)$assignment['bus_id']]);
        if ($stmt->fetch()) { $pdo->rollBack(); jsonResponse(['success'=>false,'message'=>'This bus already has an active trip.'],409); }

        $stmt = $pdo->prepare("INSERT INTO trips (bus_id,driver_id,route_id,start_time,status) VALUES (?,?,?,?, 'active')");
        $stmt->execute([(int)$assignment['bus_id'],(int)$user['id'],(int)$assignment['route_id'],date('Y-m-d H:i:s')]);
        $tripId = (int)$pdo->lastInsertId();
        $pdo->commit();
        jsonResponse(['success'=>true,'message'=>'Trip started.','trip_id'=>$tripId,'assignment'=>$assignment]);
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        jsonResponse(['success'=>false,'message'=>'Unable to start trip.'],500);
    }
}

if ($action === 'end') {
    $stmt = $pdo->prepare("UPDATE trips SET end_time=?,status='completed' WHERE driver_id=? AND bus_id=? AND route_id=? AND status='active'");
    $stmt->execute([date('Y-m-d H:i:s'),(int)$user['id'],(int)$assignment['bus_id'],(int)$assignment['route_id']]);
    if ($stmt->rowCount() < 1) jsonResponse(['success'=>false,'message'=>'No active trip was found.'],409);
    jsonResponse(['success'=>true,'message'=>'Trip completed successfully.']);
}

jsonResponse(['success'=>false,'message'=>'Unknown trip action.'],422);
?>
