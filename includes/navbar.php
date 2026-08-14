<?php
require_once __DIR__ . '/auth.php';
$user = currentUser();
?>
<nav class="navbar">
    <div class="nav-inner">
        <a class="brand" href="/smart-transit/index.php">
            <span class="brand-icon">🚌</span>
            <span>Smart<span>Transit</span></span>
        </a>

        <button class="menu-toggle" id="menuToggle" aria-label="Open menu">☰</button>

        <div class="nav-links" id="navLinks">
            <a href="/smart-transit/index.php">Home</a>
            <a href="/smart-transit/passenger/routes.php">Routes</a>
            <a href="/smart-transit/passenger/buses.php">Buses</a>
            <a href="/smart-transit/passenger/schedules.php">Schedules</a>
            <a href="/smart-transit/about.php">About</a>

            <?php if ($user && $user['role'] === 'passenger'): ?>
                <a href="/smart-transit/passenger/dashboard.php">Dashboard</a>
                <a href="/smart-transit/passenger/notices.php">Notices</a>
                <a href="/smart-transit/passenger/profile.php">Profile</a>
                <a class="nav-button" href="/smart-transit/logout.php">Logout</a>
            <?php elseif ($user && $user['role'] === 'driver'): ?>
                <a href="/smart-transit/driver/dashboard.php">Driver Dashboard</a>
                <a class="nav-button" href="/smart-transit/logout.php">Logout</a>
            <?php elseif ($user && $user['role'] === 'admin'): ?>
                <a href="/smart-transit/admin/dashboard.php">Admin Dashboard</a>
                <a class="nav-button" href="/smart-transit/logout.php">Logout</a>
            <?php else: ?>
                <a href="/smart-transit/login.php">Login</a>
                <a class="nav-button" href="/smart-transit/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>