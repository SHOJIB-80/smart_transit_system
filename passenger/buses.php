<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$filter = $_GET['filter'] ?? 'all';
$sql = "SELECT b.*,
    (SELECT COUNT(*) FROM bus_occupancy bo WHERE bo.bus_id=b.id AND bo.exited_at IS NULL) AS current_passengers
    FROM buses b WHERE 1=1"; $params=[];
if ($filter==='active') $sql .= " AND status='active'";
if ($filter==='women') $sql .= " AND women_only=1";
$sql .= " ORDER BY b.bus_number";
$buses=$pdo->prepare($sql); $buses->execute($params); $buses=$buses->fetchAll();

$pageTitle='Buses'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<div class="page-heading"><div><span class="eyebrow">FLEET</span><h1>Available Buses</h1><p>Browse the demonstration bus fleet and current passenger density.</p></div></div>
<div class="filter-tabs"><a class="<?= $filter==='all'?'active':'' ?>" href="?filter=all">All</a><a class="<?= $filter==='active'?'active':'' ?>" href="?filter=active">Active</a><a class="<?= $filter==='women'?'active':'' ?>" href="?filter=women">Women-only</a></div>
<div class="bus-grid">
<?php foreach($buses as $b):
    $capacity=max(1,(int)$b['capacity']); $passengers=(int)$b['current_passengers']; $pct=min(100,(int)round(($passengers/$capacity)*100));
    $density=$pct<50?'LOW':($pct<80?'MEDIUM':'HIGH');
?>
<article class="bus-card">
<div class="bus-top"><span class="bus-number"><?= e($b['bus_number']) ?></span><span class="badge <?= $b['status']==='active'?'success':'' ?>"><?= e(ucfirst($b['status'])) ?></span></div>
<h3><?= e($b['bus_type']) ?></h3>
<div class="occupancy-mini"><strong><?= $passengers ?> / <?= $capacity ?></strong><span>Passengers</span><b class="density-<?= strtolower($density) ?>"><?= $density ?></b></div>
<div class="occupancy-meter"><i style="width:<?= $pct ?>%"></i></div>
<p>Occupancy: <?= $pct ?>%</p>
<?php if($b['women_only']): ?><span class="women-tag">Women-only</span><?php endif; ?>
<div class="bus-card-actions">
<a class="btn btn-small" href="bus-details.php?id=<?= (int)$b['id'] ?>">View Details</a>
<?php if($b['status']==='active'): ?><a class="btn btn-small btn-outline" href="bus-details.php?id=<?= (int)$b['id'] ?>#occupancy">Board / Leave</a><?php endif; ?>
</div>
</article>
<?php endforeach; ?>
</div>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>