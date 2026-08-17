<?php
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
$routes=$pdo->query("SELECT r.id,r.route_name,r.route_code,r.starting_point,r.ending_point,COUNT(s.id) stop_count FROM routes r LEFT JOIN stops s ON s.route_id=r.id WHERE r.status='active' GROUP BY r.id ORDER BY r.route_name")->fetchAll();
echo json_encode(['success'=>true,'data'=>$routes]);