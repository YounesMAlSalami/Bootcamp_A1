<?php
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$hostName = parse_url('http://' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
$isLocalhost = in_array($hostName, ['localhost', '127.0.0.1'], true);
$secureCookie = $isHttps || $isLocalhost;

session_name('SECURESESSID');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secureCookie,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        http_response_code(403);
        $message = 'CSRF validation failed. Request rejected.';
    } elseif (isset($_POST['login'])) {
        session_regenerate_id(true);
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = 'Student';
        $message = 'Login simulation successful. Session ID was regenerated.';
    } elseif (isset($_POST['logout'])) {
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $message = 'Logout successful. Authentication data was cleared and the session ID was changed.';
    } elseif (isset($_POST['create_demo_cookie'])) {
        setcookie('DEMO_UNPROTECTED', 'visible-to-javascript', [
            'expires' => time() + 3600,
            'path' => '/',
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Lax'
        ]);
        $message = 'An intentionally unprotected demonstration cookie was created.';
    } elseif (isset($_POST['delete_demo_cookie'])) {
        setcookie('DEMO_UNPROTECTED', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Lax'
        ]);
        $message = 'The demonstration cookie was deleted.';
    }
}

$sessionFingerprint = substr(hash('sha256', session_id()), 0, 12);
$cookieParams = session_get_cookie_params();
$authenticated = !empty($_SESSION['authenticated']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Session and Cookie Management</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 850px; margin: 35px auto; padding: 0 18px; background: #f4f6f8; color: #202833; }
        h1 { color: #17365d; }
        .card { background: white; padding: 20px; margin: 16px 0; border-radius: 8px; border: 1px solid #dce2e8; }
        button { padding: 10px 15px; margin: 5px 5px 5px 0; border: 0; border-radius: 5px; background: #175ea8; color: white; cursor: pointer; }
        .danger { background: #a83232; }
        .message { padding: 12px; background: #e8f4ff; border-left: 4px solid #175ea8; }
        code { overflow-wrap: anywhere; }
        .good { color: #137333; font-weight: bold; }
        .bad { color: #b3261e; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Secure Session and Cookie Management</h1>
    <p>This page demonstrates protected session cookies, session ID regeneration, and the difference between HttpOnly and JavaScript-readable cookies.</p>

    <?php if ($message !== ''): ?>
        <div class="card message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <section class="card">
        <h2>Session status</h2>
        <p>Status: <strong><?= $authenticated ? 'Logged in' : 'Not logged in' ?></strong></p>
        <p>Session ID fingerprint: <code><?= htmlspecialchars($sessionFingerprint, ENT_QUOTES, 'UTF-8') ?></code></p>
        <p>The fingerprint is shown instead of exposing the actual session ID.</p>
        <?php if ($authenticated): ?>
            <p>Username: <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></p>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <button class="danger" type="submit" name="logout">Logout</button>
            </form>
        <?php else: ?>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" name="login">Simulate Login</button>
            </form>
        <?php endif; ?>
    </section>

    <section class="card">
        <h2>Protected session cookie settings</h2>
        <p>Cookie name: <code><?= htmlspecialchars(session_name(), ENT_QUOTES, 'UTF-8') ?></code></p>
        <p>HttpOnly: <span class="good">true</span></p>
        <p>SameSite: <span class="good"><?= htmlspecialchars($cookieParams['samesite'], ENT_QUOTES, 'UTF-8') ?></span></p>
        <p>Secure: <span class="<?= $cookieParams['secure'] ? 'good' : 'bad' ?>"><?= $cookieParams['secure'] ? 'true' : 'false' ?></span></p>
        <p>Secure is enabled for HTTPS and localhost. For a deployed website, use HTTPS.</p>
    </section>

    <section class="card">
        <h2>Cookie comparison test</h2>
        <p>Use the buttons to create or delete an intentionally unprotected cookie for comparison.</p>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" name="create_demo_cookie">Create unprotected demo cookie</button>
            <button class="danger" type="submit" name="delete_demo_cookie">Delete demo cookie</button>
        </form>
        <p>JavaScript document.cookie result:</p>
        <pre id="cookie-result">Checking...</pre>
        <p>The protected SECURESESSID cookie should not appear here because it is HttpOnly. The DEMO_UNPROTECTED cookie should appear after you create it.</p>
    </section>

    <script>
        document.getElementById('cookie-result').textContent = document.cookie || '(No JavaScript-readable cookies)';
    </script>
</body>
</html>
