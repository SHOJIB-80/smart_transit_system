<?php
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
$buses=$pdo->query("SELECT id,bus_number,registration_number,bus_type,capacity,women_only,status FROM buses ORDER BY bus_number")->fetchAll();
echo json_encode(['success'=>true,'data'=>$buses]);