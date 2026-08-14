<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

if (isLoggedIn()) redirect('/smart-transit/index.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'Invalid form request.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = $pdo->prepare("SELECT id,name,email,phone,password,role,status FROM users WHERE email=? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $user['status'] === 'active' && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            unset($user['password']);
            $_SESSION['user'] = $user;
            if ($user['role'] === 'passenger') redirect('/smart-transit/passenger/dashboard.php');
            if ($user['role'] === 'driver') redirect('/smart-transit/driver/dashboard.php');
            redirect('/smart-transit/admin/dashboard.php');
        } else {
            $error = 'Incorrect email or password.';
        }
    }
}

$pageTitle = 'Login';
require __DIR__ . '/includes/header.php';
?>
<main class="section auth-page"><div class="auth-card">
<h1>Welcome back</h1><p class="muted">Sign in to access your SmartTransit account.</p>
<?php if (isset($_GET['registered'])): ?><div class="alert success">Registration successful. You can now log in.</div><?php endif; ?>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="form-grid">
<input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
<label>Email<input required type="email" name="email"></label>
<label>Password<input required type="password" name="password"></label>
<button class="btn full" type="submit">Login</button>
</form>
<p class="form-footer">New passenger? <a href="/smart-transit/register.php">Create an account</a></p>
</div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>