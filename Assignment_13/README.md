# Assignment 13 — Secure Session and Cookie Management
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** PHP  
**Main file:** `secure_session_cookie.php`

## Overview
Demonstrates secure PHP session-cookie configuration, session ID regeneration during a simulated login, and a comparison between an HttpOnly session cookie and a JavaScript-readable demonstration cookie.

## Requirements
- PHP 8.x recommended
- XAMPP or PHP built-in development server
- Modern browser with Developer Tools

## Project structure
```text
Assignment_13/
└── secure_session_cookie.php
```

## Security features
- `session_set_cookie_params()` configures cookie options before the session starts.
- `httponly => true` prevents normal JavaScript access to the session cookie.
- `samesite => 'Strict'` restricts cross-site cookie sending.
- `secure => true` marks the cookie for secure HTTPS transport.
- `session_regenerate_id(true)` replaces the session ID after the simulated login.
- `setcookie()` creates the comparison cookie.

## Run
From the project directory:
```powershell
C:\xampp\php\php.exe -S localhost:8003
```
Open `http://localhost:8003/secure_session_cookie.php`.

## How to test
1. Open Developer Tools with F12.
2. Open Application/Storage, then Cookies for localhost.
3. Inspect the session cookie's HttpOnly, Secure, and SameSite attributes.
4. Check the page's `document.cookie` output; the HttpOnly session cookie should not appear.
5. Create the unprotected demo cookie and confirm it is visible to JavaScript.
6. Record the displayed session ID fingerprint, use the simulated login control, and confirm the fingerprint changes.

## Validation status
PHP syntax passed. The local PHP server was started, and session-cookie issuance and session ID regeneration were exercised. The response contained `Secure`, `HttpOnly`, and `SameSite=Strict` attributes. Login is a demonstration only; no real account/password authentication is implemented.

## Important HTTPS note
Secure cookies are intended for HTTPS. Localhost behavior over plain HTTP may vary by browser. Use HTTPS in production and inspect the actual `Set-Cookie` response header.

## Security considerations and limitations
HttpOnly reduces JavaScript access to the cookie but does not eliminate XSS. SameSite is a CSRF mitigation, not a complete substitute for CSRF tokens in sensitive operations. Production systems also need real authentication, authorization, logout invalidation, secure session storage, and timeout policies.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
