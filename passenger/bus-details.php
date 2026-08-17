<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT * FROM buses WHERE id=?"); $stmt->execute([$id]); $bus=$stmt->fetch();
if(!$bus){http_response_code(404);die('Bus not found.');}
$stmt=$pdo->prepare("SELECT s.*,r.route_name,r.route_code FROM schedules s JOIN routes r ON r.id=s.route_id WHERE s.bus_id=? ORDER BY s.departure_time");
$stmt->execute([$id]); $schedules=$stmt->fetchAll();

$pageTitle='Bus Details'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<a class="back-link" href="buses.php">← Back to buses</a>
<div class="bus-detail panel"><div><span class="route-code"><?= e($bus['bus_number']) ?></span><h1><?= e($bus['bus_type']) ?></h1><p>Registration: <?= e($bus['registration_number']) ?></p></div><div class="detail-list"><div><span>Capacity</span><b><?= (int)$bus['capacity'] ?></b></div><div><span>Status</span><b><?= e(ucfirst($bus['status'])) ?></b></div><div><span>Women-only</span><b><?= $bus['women_only']?'Yes':'No' ?></b></div></div></div>
<section class="panel"><h2>Associated Schedules</h2>
<?php foreach($schedules as $s): ?><div class="schedule-row"><strong><?= e($s['route_code']) ?> · <?= e($s['route_name']) ?></strong><span><?= e($s['departure_time']) ?> → <?= e($s['arrival_time']) ?></span><small><?= e($s['operating_days']) ?></small></div><?php endforeach; ?>
<?php if(!$schedules): ?><div class="empty">No associated schedules.</div><?php endif; ?>
</section>
<p class="muted">Live GPS location is intentionally not implemented in Part 1.</p>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>