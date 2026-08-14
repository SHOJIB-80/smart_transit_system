<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireRole('driver');
$pageTitle='Driver Dashboard'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container narrow"><span class="eyebrow">DRIVER AREA</span><h1>Driver Dashboard</h1><div class="notice-box"><strong>Part 1 foundation:</strong> Driver authentication is ready. Complete trip management, vehicle condition, GPS and emergency reporting will be implemented in Part 2.</div></div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>