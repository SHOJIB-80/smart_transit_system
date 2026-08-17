<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
$notices=$pdo->query("SELECT * FROM notices WHERE status='active' ORDER BY FIELD(priority,'high','medium','low'),created_at DESC")->fetchAll();
$pageTitle='Notices'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<div class="page-heading"><div><span class="eyebrow">SERVICE INFORMATION</span><h1>Notices</h1><p>Important transit information for passengers.</p></div></div>
<div class="notice-list">
<?php foreach($notices as $n): ?><article class="notice <?= e($n['notice_type']) ?>"><div><span class="badge"><?= e(ucfirst($n['notice_type'])) ?></span><span class="muted"><?= e($n['priority']) ?> priority</span></div><h2><?= e($n['title']) ?></h2><p><?= e($n['message']) ?></p><small><?= e($n['created_at']) ?></small></article><?php endforeach; ?>
<?php if(!$notices): ?><div class="empty">No active notices.</div><?php endif; ?>
</div></div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>