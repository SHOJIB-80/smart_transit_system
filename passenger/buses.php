<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$filter = $_GET['filter'] ?? 'all';
$sql = "SELECT * FROM buses WHERE 1=1"; $params=[];
if ($filter==='active') $sql .= " AND status='active'";
if ($filter==='women') $sql .= " AND women_only=1";
$sql .= " ORDER BY bus_number";
$buses=$pdo->prepare($sql); $buses->execute($params); $buses=$buses->fetchAll();

$pageTitle='Buses'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<div class="page-heading"><div><span class="eyebrow">FLEET</span><h1>Available Buses</h1><p>Browse the demonstration bus fleet.</p></div></div>
<div class="filter-tabs"><a class="<?= $filter==='all'?'active':'' ?>" href="?filter=all">All</a><a class="<?= $filter==='active'?'active':'' ?>" href="?filter=active">Active</a><a class="<?= $filter==='women'?'active':'' ?>" href="?filter=women">Women-only</a></div>
<div class="bus-grid">
<?php foreach($buses as $b): ?><article class="bus-card"><div class="bus-top"><span class="bus-number"><?= e($b['bus_number']) ?></span><span class="badge <?= $b['status']==='active'?'success':'' ?>"><?= e(ucfirst($b['status'])) ?></span></div><h3><?= e($b['bus_type']) ?></h3><p>Capacity: <?= (int)$b['capacity'] ?></p><?php if($b['women_only']): ?><span class="women-tag">Women-only</span><?php endif; ?><a class="btn btn-small" href="bus-details.php?id=<?= (int)$b['id'] ?>">View Details</a></article><?php endforeach; ?>
</div>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>