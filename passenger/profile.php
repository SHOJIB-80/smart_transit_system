<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireRole('passenger');
$user=currentUser();
$pageTitle='Profile'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container narrow"><span class="eyebrow">ACCOUNT</span><h1>Your Profile</h1><div class="panel profile"><div><span>Name</span><strong><?= e($user['name']) ?></strong></div><div><span>Email</span><strong><?= e($user['email']) ?></strong></div><div><span>Phone</span><strong><?= e($user['phone']) ?></strong></div><div><span>Role</span><strong><?= e(ucfirst($user['role'])) ?></strong></div></div></div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>