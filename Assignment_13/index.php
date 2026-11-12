<?php
require_once __DIR__ . '/includes/auth.php';
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request. Refresh the page and try again.';
    } elseif ($username === 'younes' && $password === 'P@ssw0rd123') {
        session_regenerate_id(true);
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        unset($_SESSION['csrf_token']);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Incorrect username or password.';
    }
}
$token = createCsrfToken();
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Secure Login</title><link rel="stylesheet" href="assets/style.css">
</head><body><main class="container narrow">
<header class="hero"><h1>Session &amp; Cookie Security</h1><p>Assignment 13 · PHP Authentication</p></header>
<section class="card"><h2>Login</h2>
<?php if ($error !== ''): ?><div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<form method="post" action="index.php">
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
<label for="username">Username</label><input id="username" name="username" required autocomplete="username">
<label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password">
<button type="submit">Log In</button></form>
<div class="credentials"><strong>Demo credentials</strong><p>Username: <code>younes</code></p><p>Password: <code>P@ssw0rd123</code></p></div>
</section><footer>Educational demonstration only. Do not use hardcoded credentials in production.</footer>
</main></body></html>
