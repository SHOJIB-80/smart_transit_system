<?php
require_once __DIR__ . '/../includes/auth.php';
header('Content-Type: application/json');
echo json_encode([
    'success'=>true,
    'logged_in'=>isLoggedIn(),
    'user'=>currentUser()
]);