<?php
require_once __DIR__ . '/_common.php';

function occupancySnapshot(PDO $pdo, int $busId): array {
    $stmt = $pdo->prepare("SELECT b.id,b.bus_number,b.capacity,
        (SELECT COUNT(*) FROM bus_occupancy bo WHERE bo.bus_id=b.id AND bo.exited_at IS NULL) AS passengers
        FROM buses b WHERE b.id=?");
    $stmt->execute([$busId]);
    $bus = $stmt->fetch();
    if (!$bus) jsonResponse(['success'=>false,'message'=>'Bus not found.'],404);

    $capacity = max(1, (int)$bus['capacity']);
    $passengers = max(0, (int)$bus['passengers']);
    $percentage = (int)round(($passengers / $capacity) * 100);
    if ($percentage < 50) $density = 'LOW';
    elseif ($percentage < 80) $density = 'MEDIUM';
    else $density = 'HIGH';

    return [
        'bus_id'=>(int)$bus['id'],
        'bus_number'=>$bus['bus_number'],
        'capacity'=>$capacity,
        'passengers'=>$passengers,
        'occupancy_percentage'=>min(100,$percentage),
        'density'=>$density
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $busId = (int)($_GET['bus_id'] ?? 0);
    if ($busId < 1) jsonResponse(['success'=>false,'message'=>'A valid bus ID is required.'],422);
    jsonResponse(['success'=>true,'occupancy'=>occupancySnapshot($pdo,$busId)]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
}

if (!isLoggedIn() || (currentUser()['role'] ?? '') !== 'passenger') {
    jsonResponse(['success'=>false,'message'=>'Passenger authentication is required.'],403);
}
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_POST['csrf_token'] ?? null);
if (!verifyCsrf($token)) {
    jsonResponse(['success'=>false,'message'=>'Invalid or expired security token. Refresh the page and try again.'],419);
}

$data = requestJson();
$action = trim((string)($data['action'] ?? ''));
$busId = (int)($data['bus_id'] ?? 0);
if (!in_array($action,['board','leave'],true) || $busId < 1) {
    jsonResponse(['success'=>false,'message'=>'Valid bus and action are required.'],422);
}

$userId = (int)(currentUser()['id'] ?? 0);

try {
    $pdo->beginTransaction();

    // Lock the bus row so simultaneous boarding cannot exceed capacity.
    $stmt = $pdo->prepare("SELECT id,bus_number,capacity,status FROM buses WHERE id=? FOR UPDATE");
    $stmt->execute([$busId]);
    $bus = $stmt->fetch();
    if (!$bus) throw new RuntimeException('Bus not found.');
    if ($bus['status'] !== 'active') throw new RuntimeException('This bus is not currently in active service.');

    if ($action === 'board') {
        $stmt = $pdo->prepare("SELECT id,bus_id FROM bus_occupancy WHERE passenger_id=? AND exited_at IS NULL LIMIT 1 FOR UPDATE");
        $stmt->execute([$userId]);
        $existing = $stmt->fetch();
        if ($existing) {
            throw new RuntimeException((int)$existing['bus_id'] === $busId
                ? 'You are already boarded on this bus.'
                : 'You are already boarded on another bus. Leave that bus before boarding another.');
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bus_occupancy WHERE bus_id=? AND exited_at IS NULL");
        $stmt->execute([$busId]);
        $current = (int)$stmt->fetchColumn();
        if ($current >= (int)$bus['capacity']) throw new RuntimeException('This bus is currently at full capacity.');

        $stmt = $pdo->prepare("INSERT INTO bus_occupancy (bus_id,passenger_id) VALUES (?,?)");
        $stmt->execute([$busId,$userId]);
        $message = 'You have boarded the bus.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM bus_occupancy WHERE bus_id=? AND passenger_id=? AND exited_at IS NULL LIMIT 1 FOR UPDATE");
        $stmt->execute([$busId,$userId]);
        $record = $stmt->fetch();
        if (!$record) throw new RuntimeException('You are not currently boarded on this bus.');

        $stmt = $pdo->prepare("UPDATE bus_occupancy SET exited_at=CURRENT_TIMESTAMP WHERE id=?");
        $stmt->execute([(int)$record['id']]);
        $message = 'You have left the bus.';
    }

    $snapshot = occupancySnapshot($pdo,$busId);
    $pdo->commit();
    jsonResponse(['success'=>true,'message'=>$message,'occupancy'=>$snapshot]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    jsonResponse(['success'=>false,'message'=>$e->getMessage()],409);
}
?>
