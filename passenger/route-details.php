<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM routes WHERE id=? AND status='active'");
$stmt->execute([$id]); $route = $stmt->fetch();
if (!$route) { http_response_code(404); die('Route not found.'); }

$stmt = $pdo->prepare("SELECT * FROM stops WHERE route_id=? ORDER BY stop_order");
$stmt->execute([$id]); $stops = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT s.*, b.bus_number FROM schedules s JOIN buses b ON b.id=s.bus_id WHERE s.route_id=? ORDER BY s.departure_time");
$stmt->execute([$id]); $schedules = $stmt->fetchAll();

$pageTitle = $route['route_name'];
require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<a class="back-link" href="routes.php">← Back to routes</a>
<div class="detail-header"><span class="route-code"><?= e($route['route_code']) ?></span><h1><?= e($route['route_name']) ?></h1><p><?= e($route['description']) ?></p></div>
<div class="detail-grid">
<section class="panel"><h2>Route Stops</h2><div class="timeline">
<?php foreach($stops as $i=>$stop): ?><div class="timeline-item"><div class="timeline-dot"><?= $i+1 ?></div><div><strong><?= e($stop['stop_name']) ?></strong><small><?= $i===0 ? 'Starting stop' : ($i===count($stops)-1 ? 'Destination' : 'Stop '.$stop['stop_order']) ?></small></div></div><?php endforeach; ?>
</div></section>
<section class="panel"><h2>Schedules & Buses</h2>
<?php foreach($schedules as $s): ?><div class="schedule-row"><strong><?= e($s['bus_number']) ?></strong><span><?= e($s['departure_time']) ?> → <?= e($s['arrival_time']) ?></span><small><?= e($s['operating_days']) ?></small></div><?php endforeach; ?>
<?php if(!$schedules): ?><div class="empty">No schedules available.</div><?php endif; ?>
</section></div>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>