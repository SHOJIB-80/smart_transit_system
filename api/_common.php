<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

function jsonResponse(array $data, int $status = 200): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function requestJson(): array {
    $raw = file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') return $_POST;
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $_POST;
}

function requireDriverJson(): array {
    if (!isLoggedIn() || (currentUser()['role'] ?? '') !== 'driver') {
        jsonResponse(['success'=>false,'message'=>'Driver authentication is required.'],403);
    }

    // State-changing JSON requests must carry the session CSRF token.
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_POST['csrf_token'] ?? null);
    if (!verifyCsrf($token)) {
        jsonResponse(['success'=>false,'message'=>'Invalid or expired security token. Refresh the page and try again.'],419);
    }

    return currentUser() ?? [];
}

function validCoordinate($lat, $lng): bool {
    return is_numeric($lat) && is_numeric($lng) &&
        (float)$lat >= -90 && (float)$lat <= 90 &&
        (float)$lng >= -180 && (float)$lng <= 180;
}
?>
