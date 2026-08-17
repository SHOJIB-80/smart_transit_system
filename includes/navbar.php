<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/config.php';
$user = currentUser();
?>
<nav class="navbar">
<div class="nav-inner">
<a class="brand" href="<?= BASE_URL ?>/index.php"><span class="brand-icon">🚌</span><span>Smart<span>Transit</span></span></a>
<button class="menu-toggle" id="menuToggle" aria-label="Open menu" type="button">☰</button>
<div class="nav-links" id="navLinks">
<a href="<?= BASE_URL ?>/index.php">Home</a>
<a href="<?= BASE_URL ?>/passenger/routes.php">Routes</a>
<a href="<?= BASE_URL ?>/passenger/buses.php">Buses</a>
<a href="<?= BASE_URL ?>/passenger/schedules.php">Schedules</a>
<a href="<?= BASE_URL ?>/about.php">About</a>
<?php if ($user && $user['role'] === 'passenger'): ?>
<a href="<?= BASE_URL ?>/passenger/dashboard.php">Dashboard</a>
<a href="<?= BASE_URL ?>/passenger/notices.php">Notices</a>
<a href="<?= BASE_URL ?>/passenger/profile.php">Profile</a>
<a class="nav-button" href="<?= BASE_URL ?>/logout.php">Logout</a>
<?php elseif ($user && $user['role'] === 'driver'): ?>
<a href="<?= BASE_URL ?>/driver/dashboard.php">Driver Dashboard</a>
<a class="nav-button" href="<?= BASE_URL ?>/logout.php">Logout</a>
<?php elseif ($user && $user['role'] === 'admin'): ?>
<a href="<?= BASE_URL ?>/admin/dashboard.php">Admin Dashboard</a>
<a class="nav-button" href="<?= BASE_URL ?>/logout.php">Logout</a>
<?php else: ?>
<a href="<?= BASE_URL ?>/login.php">Login</a>
<a class="nav-button" href="<?= BASE_URL ?>/register.php">Register</a>
<?php endif; ?>
</div>
</div>
</nav>
