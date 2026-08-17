<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireRole('admin');
$adminUser = currentUser();

function adminLog(string $action, ?string $type=null, ?int $id=null, ?string $details=null): void {
    global $pdo, $adminUser;
    try {
        $stmt=$pdo->prepare("INSERT INTO activity_logs(user_id,action,entity_type,entity_id,details) VALUES(?,?,?,?,?)");
        $stmt->execute([(int)$adminUser['id'],$action,$type,$id,$details]);
    } catch (Throwable $e) {}
}
function adminRedirect(string $page): never { header('Location: '.BASE_URL.'/admin/'.$page); exit; }
function postString(string $key, string $default=''): string { return trim((string)($_POST[$key] ?? $default)); }
function postInt(string $key): int { return (int)($_POST[$key] ?? 0); }
function flash(string $type,string $message): void { $_SESSION['admin_flash']=['type'=>$type,'message'=>$message]; }
function takeFlash(): ?array { $f=$_SESSION['admin_flash']??null; unset($_SESSION['admin_flash']); return $f; }
function checkPostCsrf(): void {
    if ($_SERVER['REQUEST_METHOD']==='POST' && !verifyCsrf($_POST['csrf_token']??null)) {
        http_response_code(419); exit('Invalid or expired form request.');
    }
}
function statusBadge(string $status): string {
    $safe=e($status);
    $class=strtolower(str_replace([' ','_'],'-',$status));
    return '<span class="admin-badge '.$class.'">'.$safe.'</span>';
}
