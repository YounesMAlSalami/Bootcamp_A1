# Assignment 13 — Secure Session and Cookie Management

**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp  
**Programming Language:** PHP

## 1. Project Overview

This project demonstrates secure session and cookie management in PHP.

It implements a login system, protects authenticated pages using PHP sessions, regenerates the session ID during login, and configures security attributes for session cookies.

It also provides a practical comparison between protected and unprotected cookies to demonstrate the purpose of the `HttpOnly` and `SameSite` attributes.

## 2. Learning Objectives

- Understand PHP sessions and cookies.
- Configure secure session cookie parameters.
- Use `HttpOnly` to prevent JavaScript from accessing protected cookies.
- Apply the `SameSite` attribute.
- Regenerate session IDs after successful authentication.
- Protect pages that require authentication.
- Implement logout and session destruction.
- Inspect cookie attributes using browser Developer Tools.

## 3. Project Structure

```text
Assignment_13_Session_Cookie_Security/
│
├── config/
│   └── session.php
│
├── includes/
│   └── auth.php
│
├── assets/
│   ├── style.css
│   └── cookie-test.js
│
├── index.php
├── dashboard.php
├── logout.php
├── cookie_test.php
└── README.md
```

## 4. Requirements

- PHP 8.x
- XAMPP or another PHP-compatible web server
- A modern web browser
- Browser Developer Tools

No database is required for this educational demonstration.

## 5. Main Security Features

### 5.1. Secure Session Configuration

The application configures PHP session cookies with security attributes, including:

- `HttpOnly`
- `SameSite=Strict`
- `Secure` when using HTTPS

### 5.2. Session ID Regeneration

After successful login, the application regenerates the session ID using:

```php
session_regenerate_id(true);
```

This helps reduce session fixation risks.

### 5.3. Authentication Protection

The dashboard requires an authenticated session. Unauthorized visitors are redirected to the login page.

### 5.4. Logout

The logout function destroys the active session and removes the authenticated state.

### 5.5. Cookie Security Comparison

The cookie testing page creates two demonstration cookies:

| Cookie | HttpOnly | SameSite |
|---|---|---|
| protected_demo | Enabled | Strict |
| unprotected_demo | Disabled | Lax |

The page also displays the cookies accessible through JavaScript.

## 6. Running the Project

### Method 1 — XAMPP

Copy the project folder to:

```text
C:\xampp\htdocs\Assignment\Assignment_13_Session_Cookie_Security
```

Start Apache from the XAMPP Control Panel.

Open the login page:

```text
http://localhost/Assignment/Assignment_13_Session_Cookie_Security/
```

### Method 2 — PHP Development Server

Open a terminal inside the project directory and run:

```powershell
C:\xampp\php\php.exe -S localhost:8003
```

Then open:

```text
http://localhost:8003/
```

## 7. Practical Testing and Evidence

The following screenshots document the application behavior and cookie security tests.

### Test 1 — Login Page and Session Cookie

The login page is displayed, and the browser Developer Tools show the PHP session cookie.

The session cookie is configured with `HttpOnly` and `SameSite=Strict`.

![Login Page and Session Cookie](screenshot(50).png)

### Test 2 — Successful Authentication

After submitting valid login credentials, the application redirects the user to the secure dashboard.

The dashboard displays the authenticated username and session information.

![Secure Dashboard](screenshot(51).png)

### Test 3 — Cookie Attributes in Browser Developer Tools

The browser Application panel displays the session cookie and the two demonstration cookies.

The protected cookie has `HttpOnly` enabled and `SameSite=Strict`.

![Cookie Attributes](screenshot(52).png)

### Test 4 — Cookie Security Comparison Page

The cookie testing page displays the configuration of both cookies.

It also explains that `HttpOnly` cookies are hidden from JavaScript.

![Cookie Security Test Page](screenshot(53).png)

### Test 5 — Invalid Login Attempt

An incorrect username or password produces an authentication error instead of granting access.

The browser also displays the demonstration cookies in the Application panel.

![Invalid Login Test](screenshot(54).png)

### Test 6 — JavaScript Cookie Access Test

The browser Console is used to execute:

```javascript
document.cookie
```

The result displays:

```text
unprotected_demo=UnprotectedCookieValue
```

The protected cookie is not visible because it has the `HttpOnly` attribute.

![JavaScript Cookie Access Test](screenshot(55).png)

## 8. Test Results Summary

| Test | Result |
|---|---|
| Login page | Displayed |
| Successful login | Confirmed |
| Dashboard access | Confirmed |
| PHP session cookie | Visible in Developer Tools |
| HttpOnly attribute | Confirmed |
| SameSite=Strict | Confirmed |
| Invalid login | Rejected |
| JavaScript access to unprotected cookie | Confirmed |
| JavaScript access to HttpOnly cookie | Blocked |

## 9. Security Notes and Limitations

- The login credentials are hardcoded for this educational demonstration and should not be used in a production application.
- The `Secure` cookie attribute requires HTTPS. It is not enabled during ordinary HTTP localhost testing.
- `HttpOnly` prevents JavaScript from reading a cookie, but it does not prevent all forms of cross-site scripting.
- `SameSite=Strict` helps restrict cross-site cookie sending but does not replace CSRF protection.
- Production authentication systems should use securely stored password hashes, proper user management, HTTPS, and additional security controls.

## 10. Validation Status

The supplied screenshots provide practical evidence of:

- Successful authentication and dashboard access.
- Session cookie configuration.
- Cookie security attribute inspection.
- Rejection of invalid login credentials.
- The difference between JavaScript-readable and `HttpOnly` cookies.

The documented results are based on the supplied browser screenshots.

## 11. Author

**Younes Al-Salami**  
Cybersecurity Programming Bootcamp
