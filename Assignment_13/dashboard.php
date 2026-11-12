<?php
require_once __DIR__ . '/includes/auth.php';
requireLogin();
$token = createCsrfToken();
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title><link rel="stylesheet" href="assets/style.css"></head>
<body><main class="container">
<header class="hero"><h1>Secure Dashboard</h1><p>Authenticated as <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></p></header>
<section class="card"><h2>Session Information</h2>
<div class="info"><p><strong>Login time:</strong> <?= htmlspecialchars($_SESSION['login_time'], ENT_QUOTES, 'UTF-8') ?></p>
<p><strong>Session ID:</strong> <span class="break"><?= htmlspecialchars(session_id(), ENT_QUOTES, 'UTF-8') ?></span></p>
<p><strong>Session cookie:</strong> HttpOnly, SameSite=Strict</p></div>
<form method="post" action="logout.php"><input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>"><button class="danger">Log Out</button></form>
</section><section class="card"><h2>Cookie Security Test</h2><p>Compare a protected cookie with a JavaScript-readable cookie.</p><a class="button-link" href="cookie_test.php">Open Cookie Test</a></section>
</main></body></html>
