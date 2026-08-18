<?php
require_once __DIR__.'/_common.php'; $adminTitle='Bus Management'; checkPostCsrf();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $action=postString('action');$id=postInt('id');
 try{
  if($action==='save'){
   $num=postString('bus_number');$reg=postString('registration_number');$type=postString('bus_type');$cap=postInt('capacity');$women=isset($_POST['women_only'])?1:0;$status=postString('status','active');
   if($num===''||$reg===''||$type===''||$cap<1) throw new Exception('Please fill all required bus fields.');
   if($id){$pdo->prepare("UPDATE buses SET bus_number=?,registration_number=?,bus_type=?,capacity=?,women_only=?,status=? WHERE id=?")->execute([$num,$reg,$type,$cap,$women,$status,$id]);adminLog('Bus updated','bus',$id,$num);flash('success','Bus updated.');}
   else{$pdo->prepare("INSERT INTO buses(bus_number,registration_number,bus_type,capacity,women_only,status) VALUES(?,?,?,?,?,?)")->execute([$num,$reg,$type,$cap,$women,$status]);$new=(int)$pdo->lastInsertId();adminLog('Bus added','bus',$new,$num);flash('success','Bus added.');}
  }elseif($action==='toggle'){$pdo->prepare("UPDATE buses SET status=IF(status='inactive','active','inactive') WHERE id=?")->execute([$id]);adminLog('Bus status changed','bus',$id);flash('success','Bus status updated.');}
  elseif($action==='delete'){$pdo->prepare("UPDATE buses SET status='inactive' WHERE id=?")->execute([$id]);adminLog('Bus deactivated','bus',$id);flash('success','Bus deactivated.');}
 }catch(Throwable $e){flash('error',$e instanceof PDOException?'Could not save bus. Check duplicate bus/registration values.':$e->getMessage());}
 adminRedirect('buses.php');
}
$edit=null;if(isset($_GET['edit'])){$st=$pdo->prepare("SELECT * FROM buses WHERE id=?");$st->execute([(int)$_GET['edit']]);$edit=$st->fetch();}
$rows=$pdo->query("SELECT b.*,
    (SELECT COUNT(*) FROM bus_occupancy bo WHERE bo.bus_id=b.id AND bo.exited_at IS NULL) AS current_passengers
    FROM buses b ORDER BY b.id DESC")->fetchAll();
require __DIR__.'/_layout.php';
?>
<div class="admin-page-head"><div><span class="admin-kicker">FLEET</span><h2>Bus Management</h2><p>Maintain the existing fleet records and service status.</p></div></div>
<div class="admin-grid-2">
<section class="admin-panel"><div class="admin-panel-head"><h3><?= $edit?'Edit Bus':'Add Bus' ?></h3><?php if($edit): ?><a href="buses.php">Cancel</a><?php endif; ?></div>
<form method="post" class="admin-form"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)($edit['id']??0) ?>">
<label>Bus Number<input required name="bus_number" value="<?= e($edit['bus_number']??'') ?>" placeholder="ST-101"></label><label>Registration Number<input required name="registration_number" value="<?= e($edit['registration_number']??'') ?>"></label><label>Bus Type<input required name="bus_type" value="<?= e($edit['bus_type']??'Standard') ?>"></label><label>Capacity<input required type="number" min="1" name="capacity" value="<?= e($edit['capacity']??45) ?>"></label><label>Service Status<select name="status"><?php foreach(['active','inactive','maintenance'] as $v): ?><option <?= ($edit['status']??'active')===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></label><label class="check-label"><input type="checkbox" name="women_only" <?= !empty($edit['women_only'])?'checked':'' ?>> Women-only service</label><button class="admin-btn"><?= $edit?'Save Changes':'Add Bus' ?></button></form></section>
<section class="admin-panel"><div class="admin-panel-head"><h3>Fleet list</h3><span><?= count($rows) ?> buses</span></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Bus</th><th>Type</th><th>Capacity</th><th>Passengers</th><th>Occupancy</th><th>Density</th><th>Status</th><th>Women-only</th><th></th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><strong><?= e($r['bus_number']) ?></strong><small><?= e($r['registration_number']) ?></small></td><td><?= e($r['bus_type']) ?></td><td><?= (int)$r['capacity'] ?></td><?php $cap=max(1,(int)$r['capacity']);$pp=(int)$r['current_passengers'];$pct=min(100,(int)round(($pp/$cap)*100));$den=$pct<50?'LOW':($pct<80?'MEDIUM':'HIGH'); ?><td><?= $pp ?></td><td><?= $pct ?>%</td><td><span class="density-<?= strtolower($den) ?> density-badge"><?= $den ?></span></td><td><?= statusBadge($r['status']) ?></td><td><?= $r['women_only']?'Yes':'No' ?></td><td class="action-links"><a href="?edit=<?= $r['id'] ?>">Edit</a><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button>Toggle</button></form></td></tr><?php endforeach; ?></tbody></table></div></section>
</div>
<?php require __DIR__.'/_layout_end.php'; ?>
