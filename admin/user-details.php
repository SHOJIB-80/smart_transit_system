<?php
require_once __DIR__.'/_common.php'; $adminTitle='User Details';
$id=(int)($_GET['id']??0);$st=$pdo->prepare("SELECT id,name,email,phone,role,status,created_at FROM users WHERE id=?");$st->execute([$id]);$u=$st->fetch();if(!$u){flash('error','User not found.');adminRedirect('users.php');}
$assignment=null;if($u['role']==='driver'){$st=$pdo->prepare("SELECT da.*,b.bus_number,r.route_code,r.route_name FROM driver_assignments da LEFT JOIN buses b ON b.id=da.bus_id LEFT JOIN routes r ON r.id=da.route_id WHERE da.driver_id=? AND da.status='active'");$st->execute([$id]);$assignment=$st->fetch();}
require __DIR__.'/_layout.php';
?>
<div class="admin-page-head"><div><span class="admin-kicker">ACCOUNT</span><h2>User Details</h2><p>Account information and current operational assignment.</p></div><a class="admin-btn" href="users.php">← Back to Users</a></div>
<section class="admin-panel detail-card"><div class="detail-avatar"><?= e(strtoupper(substr($u['name'],0,1))) ?></div><div><h3><?= e($u['name']) ?></h3><p><?= e($u['email']) ?> · <?= e($u['phone']) ?></p></div><div class="detail-grid"><div><small>Role</small><?= statusBadge($u['role']) ?></div><div><small>Status</small><?= statusBadge($u['status']) ?></div><div><small>Created</small><?= e($u['created_at']) ?></div><?php if($assignment): ?><div><small>Assigned Bus</small><?= e($assignment['bus_number']) ?></div><div><small>Assigned Route</small><?= e($assignment['route_code'].' — '.$assignment['route_name']) ?></div><?php endif; ?></div></section>
<?php require __DIR__.'/_layout_end.php'; ?>
