<?php
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
$data=$pdo->query("SELECT s.id,r.route_name,r.route_code,b.bus_number,s.departure_time,s.arrival_time,s.operating_days,s.status FROM schedules s JOIN routes r ON r.id=s.route_id JOIN buses b ON b.id=s.bus_id ORDER BY s.departure_time")->fetchAll();
echo json_encode(['success'=>true,'data'=>$data]);