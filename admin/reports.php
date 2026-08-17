<?php
require_once __DIR__.'/_common.php'; $adminTitle='Reports';
function c($q){global $pdo;try{return (int)$pdo->query($q)->fetchColumn();}catch(Throwable $e){return 0;}}
$userRoles=$pdo->query("SELECT role,COUNT(*) total FROM users GROUP BY role")->fetchAll();
$busStatus=$pdo->query("SELECT status,COUNT(*) total FROM buses GROUP BY status")->fetchAll();
$routeStatus=$pdo->query("SELECT status,COUNT(*) total FROM routes GROUP BY status")->fetchAll();
$condition=$pdo->query("SELECT condition_status,COUNT(*) total FROM vehicle_conditions WHERE id IN (SELECT MAX(id) FROM vehicle_conditions GROUP BY bus_id) GROUP BY condition_status")->fetchAll();
$emergency=$pdo->query("SELECT status,severity,COUNT(*) total FROM emergency_reports GROUP BY status,severity ORDER BY status")->fetchAll();
require __DIR__.'/_layout.php';
?>
<div class="admin-page-head print-hide"><div><span class="admin-kicker">ANALYTICS</span><h2>Reports</h2><p>Simple database-backed operational summaries for the university project.</p></div><button class="admin-btn" onclick="window.print()">Print Report</button></div>
<div class="report-grid"><div class="report-card"><span>Total Users</span><strong><?= c("SELECT COUNT(*) FROM users") ?></strong></div><div class="report-card"><span>Total Buses</span><strong><?= c("SELECT COUNT(*) FROM buses") ?></strong></div><div class="report-card"><span>Active Routes</span><strong><?= c("SELECT COUNT(*) FROM routes WHERE status='active'") ?></strong></div><div class="report-card"><span>Completed Trips</span><strong><?= c("SELECT COUNT(*) FROM trips WHERE status='completed'") ?></strong></div><div class="report-card"><span>Active Trips</span><strong><?= c("SELECT COUNT(*) FROM trips WHERE status='active'") ?></strong></div><div class="report-card"><span>Open Emergencies</span><strong><?= c("SELECT COUNT(*) FROM emergency_reports WHERE status IN ('New','Investigating')") ?></strong></div></div>
<div class="report-columns">
<section class="admin-panel"><div class="admin-panel-head"><h3>User statistics</h3></div><table class="admin-table"><tbody><?php foreach($userRoles as $r): ?><tr><td><?= e(ucfirst($r['role'])) ?></td><td><strong><?= $r['total'] ?></strong></td></tr><?php endforeach; ?></tbody></table></section>
<section class="admin-panel"><div class="admin-panel-head"><h3>Fleet statistics</h3></div><table class="admin-table"><tbody><?php foreach($busStatus as $r): ?><tr><td><?= statusBadge($r['status']) ?></td><td><strong><?= $r['total'] ?></strong></td></tr><?php endforeach; ?></tbody></table></section>
<section class="admin-panel"><div class="admin-panel-head"><h3>Vehicle condition</h3></div><table class="admin-table"><tbody><?php foreach($condition as $r): ?><tr><td><?= statusBadge($r['condition_status']) ?></td><td><strong><?= $r['total'] ?></strong></td></tr><?php endforeach; ?></tbody></table></section>
<section class="admin-panel"><div class="admin-panel-head"><h3>Emergencies</h3></div><table class="admin-table"><tbody><?php foreach($emergency as $r): ?><tr><td><?= statusBadge($r['severity']) ?> <?= statusBadge($r['status']) ?></td><td><strong><?= $r['total'] ?></strong></td></tr><?php endforeach; ?></tbody></table></section>
</div>
<?php require __DIR__.'/_layout_end.php'; ?>
