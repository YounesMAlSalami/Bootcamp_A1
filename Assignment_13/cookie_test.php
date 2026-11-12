<?php
require_once __DIR__ . '/includes/auth.php';
requireLogin();
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
setcookie('protected_demo', 'ProtectedCookieValue', [
    'expires' => time() + 1800, 'path' => '/', 'secure' => $isHttps,
    'httponly' => true, 'samesite' => 'Strict'
]);
setcookie('unprotected_demo', 'UnprotectedCookieValue', [
    'expires' => time() + 1800, 'path' => '/', 'secure' => $isHttps,
    'httponly' => false, 'samesite' => 'Lax'
]);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cookie Security Test</title><link rel="stylesheet" href="assets/style.css">
<script src="assets/cookie-test.js" defer></script></head><body><main class="container">
<header class="hero"><h1>Cookie Security Test</h1><p>HttpOnly and SameSite comparison</p></header>
<section class="card"><h2>Cookie Configuration</h2>
<div class="table-wrap"><table><tr><th>Cookie</th><th>HttpOnly</th><th>SameSite</th></tr>
<tr><td>protected_demo</td><td>Enabled</td><td>Strict</td></tr>
<tr><td>unprotected_demo</td><td>Disabled</td><td>Lax</td></tr></table></div>
<p class="muted">Secure is <?= $isHttps ? 'enabled' : 'disabled because this is HTTP' ?>.</p></section>
<section class="card"><h2>JavaScript document.cookie</h2>
<p>HttpOnly cookies are hidden from JavaScript.</p><pre id="cookie-output" class="code-output">Loading...</pre>
<button id="refresh-cookies" type="button">Refresh Result</button></section>
<a class="button-link secondary" href="dashboard.php">Back to Dashboard</a>
</main></body></html>
