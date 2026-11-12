# Assignment 13 — Secure Session and Cookie Management
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Languages:** PHP

## Overview
Demonstrates secure PHP session-cookie configuration, session ID regeneration during a simulated login, and a comparison between an HttpOnly session cookie and a JavaScript-readable demonstration cookie.
## Project Structure
- `config/session.php`: secure PHP session configuration.
- `includes/auth.php`: authentication checks and CSRF token helpers.
- `index.php`: login page and demo authentication.
- `dashboard.php`: protected dashboard.
- `logout.php`: CSRF-protected logout and session destruction.
- `cookie_test.php`: creates and compares the two test cookies.
- `assets/style.css`: page styling.
- `assets/cookie-test.js`: displays JavaScript-readable cookies.

## Requirements
PHP and XAMPP (Apache). The project uses PHP sessions and does not require a database.

## Run
From the project directory:
```text
`C:\xampp\php\php.exe -S localhost:8003`
```

Opne Browser then visit:
```text
`http://localhost/Assignment/Assignment_13_Session_Cookie_Security/`
```

Another way:
Copy this folder to 
```text
C:\xampp\htdocs\Assignment\Assignment_13_Session_Cookie_Security 
```
start Apache, then visit 
```text
http://localhost/Assignment/Assignment_13_Session_Cookie_Security/
```

## Demo Login
Username: `younes`
Password: `P@ssw0rd123`

## Tests
1. Try correct and incorrect login credentials.
2. Open `dashboard.php` in a private browser before logging in; it should redirect to login.
3. Log in and inspect the PHP session cookie in Developer Tools.
4. Open Cookie Security Test. `protected_demo` has HttpOnly enabled and `unprotected_demo` does not.
5. Run `document.cookie` in the browser console. `unprotected_demo` should be visible; `protected_demo` should not.
6. Log out and try opening `dashboard.php` again.

## Security Notes
The demo credentials are hardcoded for this educational assignment only. The intentionally unprotected cookie contains a non-sensitive demonstration value. The Secure attribute is enabled only over HTTPS; local HTTP testing does not set it. Do not deploy this demonstration as a production authentication system.

## Author
** *Younes Al-Salami* — Cybersecurity Programming Bootcamp**
