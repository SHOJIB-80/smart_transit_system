<?php
require_once __DIR__.'/_common.php'; $adminTitle='Activity Log';
$rows=$pdo->query("SELECT a.*,u.name FROM activity_logs a LEFT JOIN users u ON u.id=a.user_id ORDER BY a.created_at DESC LIMIT 200")->fetchAll();
require __DIR__.'/_layout.php';
?>
<div class="admin-page-head"><div><span class="admin-kicker">AUDIT TRAIL</span><h2>Activity Log</h2><p>Recent important administrator actions.</p></div></div>
<section class="admin-panel"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Date</th><th>Administrator</th><th>Action</th><th>Entity</th><th>Details</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['created_at']) ?></td><td><?= e($r['name']??'System') ?></td><td><strong><?= e($r['action']) ?></strong></td><td><?= e(($r['entity_type']??'').' #'.($r['entity_id']??'')) ?></td><td><?= e($r['details']??'') ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<?php require __DIR__.'/_layout_end.php'; ?>
