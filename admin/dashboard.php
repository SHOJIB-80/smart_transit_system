<?php
require_once __DIR__.'/_common.php';
$adminTitle='Dashboard';
function countQ($sql){global $pdo; try{return (int)$pdo->query($sql)->fetchColumn();}catch(Throwable $e){return 0;}}
$stats=[
 'users'=>countQ("SELECT COUNT(*) FROM users"),
 'passengers'=>countQ("SELECT COUNT(*) FROM users WHERE role='passenger'"),
 'drivers'=>countQ("SELECT COUNT(*) FROM users WHERE role='driver'"),
 'buses'=>countQ("SELECT COUNT(*) FROM buses"),
 'active_buses'=>countQ("SELECT COUNT(*) FROM buses WHERE status='active'"),
 'routes'=>countQ("SELECT COUNT(*) FROM routes"),
 'trips'=>countQ("SELECT COUNT(*) FROM trips WHERE status='active'"),
 'emergencies'=>countQ("SELECT COUNT(*) FROM emergency_reports WHERE status IN ('New','Investigating')"),
 'attention'=>countQ("SELECT COUNT(*) FROM (SELECT bus_id, condition_status, MAX(reported_at) d FROM vehicle_conditions GROUP BY bus_id) x WHERE condition_status <> 'Good'")
];
$recent=[];
try{$recent=$pdo->query("SELECT e.*,u.name driver,b.bus_number,r.route_code FROM emergency_reports e JOIN users u ON u.id=e.driver_id JOIN buses b ON b.id=e.bus_id JOIN routes r ON r.id=e.route_id ORDER BY e.created_at DESC LIMIT 6")->fetchAll();}catch(Throwable $e){}
require __DIR__.'/_layout.php';
?>
<section class="admin-welcome"><div><span class="admin-kicker">SMART TRANSIT CONTROL CENTER</span><h2>Good day, <?= e($adminUser['name']) ?> 👋</h2><p>Monitor the network and manage your transit operations from one place.</p></div><a class="admin-btn" href="<?= BASE_URL ?>/admin/live.php">● Open Live Monitor</a></section>
<div class="admin-stats">
<?php $cards=[['users','Total Users','👥'],['passengers','Passengers','♙'],['drivers','Drivers','♟'],['buses','Total Buses','🚌'],['active_buses','Active Buses','●'],['routes','Routes','⌁'],['trips','Active Trips','↻'],['emergencies','Open Emergencies','!'],['attention','Vehicles Attention','⚠']]; foreach($cards as [$k,$label,$icon]): ?>
<div class="admin-stat <?= in_array($k,['emergencies','attention'])&&$stats[$k]>0?'alert-stat':'' ?>"><span><?= $icon ?></span><div><strong><?= $stats[$k] ?></strong><small><?= $label ?></small></div></div>
<?php endforeach; ?>
</div>
<div class="admin-grid-2">
<section class="admin-panel"><div class="admin-panel-head"><div><span class="admin-kicker">NETWORK</span><h3>System overview</h3></div><a href="<?= BASE_URL ?>/admin/reports.php">View reports →</a></div>
<div class="admin-bars">
<?php foreach([['Passengers',$stats['passengers']],['Drivers',$stats['drivers']],['Active buses',$stats['active_buses']],['Routes',$stats['routes']]] as $row): $max=max(1,$stats['users'],$stats['buses'],$stats['routes']); ?>
<div><label><?= e($row[0]) ?><b><?= $row[1] ?></b></label><div class="bar"><i style="width:<?= min(100,round(($row[1]/$max)*100)) ?>%"></i></div></div>
<?php endforeach; ?>
</div></section>
<section class="admin-panel"><div class="admin-panel-head"><div><span class="admin-kicker">QUICK ACTIONS</span><h3>Manage system</h3></div></div>
<div class="quick-actions">
<a href="<?= BASE_URL ?>/admin/users.php">♙ <span>Manage Users</span></a><a href="<?= BASE_URL ?>/admin/buses.php">🚌 <span>Manage Buses</span></a><a href="<?= BASE_URL ?>/admin/routes.php">⌁ <span>Manage Routes</span></a><a href="<?= BASE_URL ?>/admin/notices.php">▤ <span>Publish Notice</span></a><a href="<?= BASE_URL ?>/admin/emergencies.php">! <span>Review Emergencies</span></a><a href="<?= BASE_URL ?>/admin/reports.php">▥ <span>Open Reports</span></a>
</div></section>
</div>
<section class="admin-panel"><div class="admin-panel-head"><div><span class="admin-kicker">LATEST INCIDENTS</span><h3>Emergency reports</h3></div><a href="<?= BASE_URL ?>/admin/emergencies.php">Manage all →</a></div>
<?php if(!$recent): ?><div class="admin-empty">No emergency reports have been submitted.</div><?php else: ?><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>Severity</th><th>Bus</th><th>Driver</th><th>Status</th><th>Date</th></tr></thead><tbody>
<?php foreach($recent as $r): ?><tr><td><strong><?= e($r['title']) ?></strong><small><?= e($r['route_code']) ?></small></td><td><?= statusBadge($r['severity']) ?></td><td><?= e($r['bus_number']) ?></td><td><?= e($r['driver']) ?></td><td><?= statusBadge($r['status']) ?></td><td><?= e($r['created_at']) ?></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?></section>
<?php require __DIR__.'/_layout_end.php'; ?>
