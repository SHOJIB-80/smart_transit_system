<?php
require_once __DIR__ . '/_common.php';
$adminTitle = $adminTitle ?? 'Admin';
$flash = takeFlash();
$emergencyCount = 0;
try { $emergencyCount=(int)$pdo->query("SELECT COUNT(*) FROM emergency_reports WHERE status IN ('New','Investigating')")->fetchColumn(); } catch(Throwable $e){}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($adminTitle) ?> | SmartTransit Admin</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head><body class="admin-body">
<div class="admin-shell">
<aside class="admin-sidebar" id="adminSidebar">
  <a class="admin-brand" href="<?= BASE_URL ?>/admin/dashboard.php"><span>🚌</span><b>Smart<span>Transit</span></b></a>
  <div class="admin-user-mini"><div class="admin-avatar"><?= e(strtoupper(substr($adminUser['name']??'A',0,1))) ?></div><div><strong><?= e($adminUser['name']) ?></strong><small>Administrator</small></div></div>
  <nav class="admin-nav">
    <a class="<?= basename($_SERVER['PHP_SELF'])==='dashboard.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/dashboard.php">▦ <span>Dashboard</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='users.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/users.php">♙ <span>Users</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='buses.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/buses.php">▣ <span>Buses</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='drivers.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/drivers.php">♟ <span>Drivers</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='routes.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/routes.php">⌁ <span>Routes & Stops</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='schedules.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/schedules.php">◷ <span>Schedules</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='vehicles.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/vehicles.php">✓ <span>Vehicle Fitness</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='live.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/live.php">● <span>Live Monitoring</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='emergencies.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/emergencies.php">! <span>Emergencies <?php if($emergencyCount): ?><em><?= $emergencyCount ?></em><?php endif; ?></span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='notices.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/notices.php">▤ <span>Notices</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='reports.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/reports.php">▥ <span>Reports</span></a>
    <a class="<?= basename($_SERVER['PHP_SELF'])==='activity.php'?'active':'' ?>" href="<?= BASE_URL ?>/admin/activity.php">◌ <span>Activity Log</span></a>
  </nav>
  <a class="admin-side-home" href="<?= BASE_URL ?>/index.php">← View Website</a>
</aside>
<div class="admin-main">
<header class="admin-topbar"><button class="admin-menu-btn" id="adminMenuBtn">☰</button><div><small>CONTROL CENTER</small><h1><?= e($adminTitle) ?></h1></div><div class="admin-top-actions"><a href="<?= BASE_URL ?>/admin/emergencies.php" title="Emergencies">🔔<?php if($emergencyCount): ?><b><?= $emergencyCount ?></b><?php endif; ?></a><a class="admin-profile" href="<?= BASE_URL ?>/admin/dashboard.php"><?= e($adminUser['name']) ?></a></div></header>
<?php if($flash): ?><div class="admin-flash <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<main class="admin-content">
