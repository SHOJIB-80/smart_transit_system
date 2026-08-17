<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireRole('passenger');
$user = currentUser();

$routes = (int)$pdo->query("SELECT COUNT(*) FROM routes WHERE status='active'")->fetchColumn();
$buses = (int)$pdo->query("SELECT COUNT(*) FROM buses WHERE status='active'")->fetchColumn();
$schedules = (int)$pdo->query("SELECT COUNT(*) FROM schedules WHERE status='active'")->fetchColumn();
$notices = (int)$pdo->query("SELECT COUNT(*) FROM notices WHERE status='active'")->fetchColumn();
$recent = $pdo->query("SELECT * FROM notices WHERE status='active' ORDER BY created_at DESC LIMIT 3")->fetchAll();

$pageTitle = 'Passenger Dashboard';
require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<div class="page-heading"><div><span class="eyebrow">PASSENGER AREA</span><h1>Welcome back, <?= e($user['name']) ?></h1><p>Here is your current transit overview.</p></div></div>
<div class="stats-grid">
<div class="stat-card"><span>Available Routes</span><strong><?= $routes ?></strong></div>
<div class="stat-card"><span>Available Buses</span><strong><?= $buses ?></strong></div>
<div class="stat-card"><span>Active Schedules</span><strong><?= $schedules ?></strong></div>
<div class="stat-card"><span>Active Notices</span><strong><?= $notices ?></strong></div>
</div>
<div class="quick-actions">
<a class="action-card" href="routes.php">🗺️ <b>Find a Route</b><small>Explore routes and stops</small></a>
<a class="action-card" href="buses.php">🚌 <b>View Buses</b><small>Check available buses</small></a>
<a class="action-card" href="schedules.php">🕐 <b>View Schedules</b><small>Check planned trips</small></a>
<a class="action-card" href="notices.php">🚨 <b>View Notices</b><small>Read service information</small></a>
</div>
<div class="section-heading"><h2>Recent Notices</h2></div>
<div class="notice-list">
<?php foreach ($recent as $n): ?><article class="notice <?= e($n['notice_type']) ?>"><span class="badge"><?= e(ucfirst($n['notice_type'])) ?></span><h3><?= e($n['title']) ?></h3><p><?= e($n['message']) ?></p></article><?php endforeach; ?>
<?php if (!$recent): ?><div class="empty">No active notices.</div><?php endif; ?>
</div>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>