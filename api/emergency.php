<?php
require_once __DIR__ . '/_common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
$user = requireDriverJson();
$data = requestJson();
$title = trim((string)($data['title'] ?? ''));
$description = trim((string)($data['description'] ?? ''));
$severity = trim((string)($data['severity'] ?? 'Medium'));
if ($title === '' || $description === '') jsonResponse(['success'=>false,'message'=>'Title and description are required.'],422);
if (!in_array($severity,['Low','Medium','High','Critical'],true)) $severity='Medium';

$stmt = $pdo->prepare("SELECT da.bus_id,da.route_id FROM driver_assignments da WHERE da.driver_id=? AND da.status='active' LIMIT 1");
$stmt->execute([(int)$user['id']]);
$assignment = $stmt->fetch();
if (!$assignment) jsonResponse(['success'=>false,'message'=>'No active assignment found.'],409);

$stmt = $pdo->prepare("INSERT INTO emergency_reports (driver_id,bus_id,route_id,title,description,severity,status) VALUES (?,?,?,?,?,?, 'New')");
$stmt->execute([(int)$user['id'],(int)$assignment['bus_id'],(int)$assignment['route_id'],$title,$description,$severity]);
jsonResponse(['success'=>true,'message'=>'Emergency report submitted.']);
?>
