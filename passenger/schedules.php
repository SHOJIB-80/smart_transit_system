<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$route=(int)($_GET['route']??0); $bus=(int)($_GET['bus']??0); $day=trim($_GET['day']??'');
$where=[];$params=[];
if($route){$where[]='s.route_id=?';$params[]=$route;}
if($bus){$where[]='s.bus_id=?';$params[]=$bus;}
if($day){$where[]='s.operating_days LIKE ?';$params[]="%$day%";}
$sql="SELECT s.*,r.route_name,r.route_code,b.bus_number FROM schedules s JOIN routes r ON r.id=s.route_id JOIN buses b ON b.id=s.bus_id";
if($where)$sql.=" WHERE ".implode(' AND ',$where);
$sql.=" ORDER BY s.departure_time";
$stmt=$pdo->prepare($sql);$stmt->execute($params);$schedules=$stmt->fetchAll();
$routes=$pdo->query("SELECT id,route_name FROM routes WHERE status='active' ORDER BY route_name")->fetchAll();
$buses=$pdo->query("SELECT id,bus_number FROM buses ORDER BY bus_number")->fetchAll();

$pageTitle='Schedules'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<div class="page-heading"><div><span class="eyebrow">TIMETABLE</span><h1>Bus Schedules</h1><p>Check planned route and bus operating times.</p></div></div>
<form class="filter-bar" method="get">
<select name="route"><option value="0">All routes</option><?php foreach($routes as $r): ?><option value="<?= $r['id'] ?>" <?= $route==$r['id']?'selected':'' ?>><?= e($r['route_name']) ?></option><?php endforeach; ?></select>
<select name="bus"><option value="0">All buses</option><?php foreach($buses as $b): ?><option value="<?= $b['id'] ?>" <?= $bus==$b['id']?'selected':'' ?>><?= e($b['bus_number']) ?></option><?php endforeach; ?></select>
<select name="day"><option value="">Any day</option><?php foreach(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $d): ?><option <?= $day===$d?'selected':'' ?>><?= $d ?></option><?php endforeach; ?></select>
<button class="btn">Filter</button></form>
<div class="table-wrap"><table><thead><tr><th>Route</th><th>Bus</th><th>Departure</th><th>Arrival</th><th>Operating Days</th><th>Status</th></tr></thead><tbody>
<?php foreach($schedules as $s): ?><tr><td><?= e($s['route_code']) ?> · <?= e($s['route_name']) ?></td><td><?= e($s['bus_number']) ?></td><td><?= e($s['departure_time']) ?></td><td><?= e($s['arrival_time']) ?></td><td><?= e($s['operating_days']) ?></td><td><span class="badge success"><?= e(ucfirst($s['status'])) ?></span></td></tr><?php endforeach; ?>
</tbody></table></div>
<?php if(!$schedules): ?><div class="empty">No schedules found.</div><?php endif; ?>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>