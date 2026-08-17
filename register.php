<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

if (isLoggedIn()) redirect(BASE_URL . '/index.php');

$errors = [];
$name = $email = $phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf($_POST['csrf_token'] ?? null)) $errors[] = 'Invalid form request. Please try again.';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($name === '') $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email.';
    if ($phone === '') $errors[] = 'Phone is required.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'An account with this email already exists.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,phone,password,role,status) VALUES (?,?,?,?, 'passenger','active')");
            $stmt->execute([$name,$email,$phone,password_hash($password,PASSWORD_DEFAULT)]);
            redirect('/smart-transit/login.php?registered=1');
        }
    }
}

$pageTitle = 'Register';
require __DIR__ . '/includes/header.php';
?>
<main class="section auth-page"><div class="auth-card">
<h1>Create your passenger account</h1><p class="muted">Registration automatically creates a passenger account.</p>
<?php if ($errors): ?><div class="alert error"><?php foreach($errors as $e): ?><div><?= e($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form method="post" class="form-grid">
<input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
<label>Full Name<input required name="name" value="<?= e($name) ?>"></label>
<label>Email<input required type="email" name="email" value="<?= e($email) ?>"></label>
<label>Phone<input required name="phone" value="<?= e($phone) ?>"></label>
<label>Password<input required type="password" name="password" minlength="8"></label>
<label>Confirm Password<input required type="password" name="confirm_password" minlength="8"></label>
<button class="btn full" type="submit">Create Account</button>
</form>
<p class="form-footer">Already registered? <a href="/smart-transit/login.php">Login</a></p>
</div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>