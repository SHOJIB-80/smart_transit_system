<?php
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
$data=$pdo->query("SELECT id,title,message,notice_type,priority,status,created_at FROM notices WHERE status='active' ORDER BY created_at DESC")->fetchAll();
echo json_encode(['success'=>true,'data'=>$data]);