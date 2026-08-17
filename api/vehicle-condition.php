<?php
require_once __DIR__ . '/_common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
$user = requireDriverJson();
$data = requestJson();
$condition = trim((string)($data['condition_status'] ?? ''));
$notes = trim((string)($data['notes'] ?? ''));
if (!in_array($condition,['Good','Needs Attention','Maintenance Required'],true)) jsonResponse(['success'=>false,'message'=>'Invalid vehicle condition.'],422);

$stmt = $pdo->prepare("SELECT bus_id FROM driver_assignments WHERE driver_id=? AND status='active' LIMIT 1");
$stmt->execute([(int)$user['id']]);
$busId = (int)$stmt->fetchColumn();
if (!$busId) jsonResponse(['success'=>false,'message'=>'No active bus assignment found.'],409);

$stmt = $pdo->prepare("INSERT INTO vehicle_conditions (bus_id,driver_id,condition_status,notes) VALUES (?,?,?,?)");
$stmt->execute([$busId,(int)$user['id'],$condition,$notes]);
jsonResponse(['success'=>true,'message'=>'Vehicle condition saved.','condition_status'=>$condition]);
?>
