<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$from = trim($_GET['from'] ?? '');
$to = trim($_GET['to'] ?? '');
$sql = "SELECT r.*, COUNT(s.id) AS stop_count FROM routes r LEFT JOIN stops s ON s.route_id=r.id WHERE r.status='active'";
$params = [];
if ($from !== '') { $sql .= " AND r.starting_point LIKE ?"; $params[] = "%$from%"; }
if ($to !== '') { $sql .= " AND r.ending_point LIKE ?"; $params[] = "%$to%"; }
$sql .= " GROUP BY r.id ORDER BY r.route_name";
$stmt = $pdo->prepare($sql); $stmt->execute($params); $routes = $stmt->fetchAll();

$pageTitle = 'Routes';
require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<div class="page-heading"><div><span class="eyebrow">TRANSPORT NETWORK</span><h1>Bus Routes</h1><p>Explore available demonstration routes and their stops.</p></div></div>
<form class="filter-bar" method="get"><input name="from" value="<?= e($from) ?>" placeholder="From"><input name="to" value="<?= e($to) ?>" placeholder="To"><button class="btn" type="submit">Search</button><a class="btn btn-light" href="routes.php">Clear</a></form>
<div class="route-grid">
<?php foreach($routes as $r): ?><article class="route-card"><div class="route-code"><?= e($r['route_code']) ?></div><h3><?= e($r['route_name']) ?></h3><div class="route-path"><span><?= e($r['starting_point']) ?></span><b>→</b><span><?= e($r['ending_point']) ?></span></div><p><?= (int)$r['stop_count'] ?> stops</p><a class="btn btn-small" href="route-details.php?id=<?= (int)$r['id'] ?>">View Route</a></article><?php endforeach; ?>
</div>
<?php if(!$routes): ?><div class="empty">No routes found.</div><?php endif; ?>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>