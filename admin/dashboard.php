<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireRole('admin');
$pageTitle='Admin Dashboard'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container narrow"><span class="eyebrow">ADMIN AREA</span><h1>Admin Dashboard</h1><div class="notice-box"><strong>Part 1 foundation:</strong> Admin authentication is ready. Full management, monitoring, vehicle fitness, emergency management and reports will be implemented in Part 3.</div></div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>