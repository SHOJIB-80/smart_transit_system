<?php
if (session_status() === PHP_SESSION_NONE) {
    $secureCookie = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secureCookie,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}

function requireRole(string $role): void {
    requireLogin();
    if (($_SESSION['user']['role'] ?? '') !== $role) {
        http_response_code(403);
        require_once __DIR__ . '/header.php';
        echo '<main class="container section"><div class="alert error"><h2>Access denied</h2><p>You do not have permission to view this page.</p><a class="btn" href="<?= BASE_URL ?>/index.php">Go Home</a></div></main>';
        require_once __DIR__ . '/footer.php';
        exit;
    }
}
?>