<?php
require_once __DIR__.'/_common.php'; $adminTitle='User Management'; checkPostCsrf();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=postInt('id'); $action=postString('action');
 if($id===(int)$adminUser['id'] && in_array($action,['toggle','role'],true)){flash('error','You cannot change your own admin account here.');adminRedirect('users.php');}
 if($action==='toggle'){ $pdo->prepare("UPDATE users SET status=IF(status='active','inactive','active') WHERE id=?")->execute([$id]); adminLog('User status changed','user',$id); flash('success','User status updated.');}
 if($action==='role'){ $role=postString('role'); if(in_array($role,['passenger','driver','admin'],true)){ $pdo->prepare("UPDATE users SET role=? WHERE id=?")->execute([$role,$id]); adminLog('User role changed','user',$id,'Role: '.$role); flash('success','User role updated.');}}
 adminRedirect('users.php');
}
$q=postString('q'); $role=$_GET['role']??''; $status=$_GET['status']??'';
$sql="SELECT id,name,email,phone,role,status,created_at FROM users WHERE 1";$p=[];
if($q!==''){$sql.=" AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";$p=["%$q%","%$q%","%$q%"];}
if(in_array($role,['passenger','driver','admin'],true)){$sql.=" AND role=?";$p[]=$role;}
if(in_array($status,['active','inactive','blocked'],true)){$sql.=" AND status=?";$p[]=$status;}
$sql.=" ORDER BY id DESC";$st=$pdo->prepare($sql);$st->execute($p);$rows=$st->fetchAll();
require __DIR__.'/_layout.php';
?>
<div class="admin-page-head"><div><span class="admin-kicker">ACCOUNTS</span><h2>User Management</h2><p>Search, filter and control registered accounts.</p></div></div>
<form class="admin-filters" method="get"><input name="q" value="<?= e($q) ?>" placeholder="Search name, email or phone"><select name="role"><option value="">All roles</option><?php foreach(['passenger','driver','admin'] as $v): ?><option <?= $role===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select><select name="status"><option value="">All statuses</option><?php foreach(['active','inactive','blocked'] as $v): ?><option <?= $status===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select><button class="admin-btn">Filter</button></form>
<section class="admin-panel"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>User</th><th>Phone</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><strong><?= e($r['name']) ?></strong><small><?= e($r['email']) ?></small></td><td><?= e($r['phone']) ?></td><td><form method="post" class="inline-form"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="id" value="<?= $r['id'] ?>"><input type="hidden" name="action" value="role"><select name="role" onchange="this.form.submit()"><?php foreach(['passenger','driver','admin'] as $v): ?><option value="<?= $v ?>" <?= $r['role']===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></form></td><td><?= statusBadge($r['status']) ?></td><td><?= e($r['created_at']) ?></td><td><?php if($r['id']!=$adminUser['id']): ?><form method="post" class="inline-form"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="id" value="<?= $r['id'] ?>"><input type="hidden" name="action" value="toggle"><button class="admin-link-btn"><?= $r['status']==='active'?'Deactivate':'Activate' ?></button></form><?php else: ?><small>Current admin</small><?php endif; ?></td></tr><?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__.'/_layout_end.php'; ?>
