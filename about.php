<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'About';
require __DIR__ . '/includes/header.php';
?>
<main class="section">
<div class="container narrow">
<span class="eyebrow">ABOUT THE PROJECT</span>
<h1>Smart Transit Navigation System</h1>
<p class="lead">A public transportation information and management platform designed to make transit information easier to access and prepare a foundation for monitoring and communication.</p>
<div class="info-grid">
<div class="info-card"><h3>For passengers</h3><p>Explore routes, stops, buses, schedules and service notices from one platform.</p></div>
<div class="info-card"><h3>For drivers</h3><p>The future driver module will support trip status, vehicle condition and emergency reporting.</p></div>
<div class="info-card"><h3>For authorities</h3><p>Later stages will provide centralized management, monitoring and reporting capabilities.</p></div>
</div>
<div class="notice-box"><strong>Part 1 scope:</strong> This version focuses on the foundation and passenger-facing core. Live GPS tracking, the full driver system and complete administration are planned for later parts.</div>
</div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>