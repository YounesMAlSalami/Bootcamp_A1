# Assignment 11 — PHP SQL Injection Defense
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** PHP  
**Main file:** `sqli_defense.php`

## Overview
Demonstrates the difference between an unsafe SQL query that concatenates user input and a safer PDO prepared statement. The educational example creates sample users in an SQLite in-memory database.

## Requirements
- PHP with PDO
- PHP `pdo_sqlite` driver enabled
- XAMPP or PHP built-in development server

## Project structure
```text
Assignment_11/
└── sqli_defense.php
```

## How it works
- Creates an in-memory SQLite database and a users table.
- Inserts sample records such as `admin`, `alice`, and `bob`.
- Unsafe mode directly concatenates the username into SQL to demonstrate the vulnerability.
- Safe mode uses PDO `prepare()` and `execute()` so input is treated as data.
- Handles PDO exceptions without exposing internal database details.

## Demonstration payload
```text
' OR '1'='1
```
In unsafe mode, this may alter the SQL condition and return multiple rows. In safe mode, the payload is treated as a literal username and should not return all users.

## Run
Check that `pdo_sqlite` is enabled:
```powershell
C:\xampp\php\php.exe -m
```
Then start the server in the project directory:
```powershell
C:\xampp\php\php.exe -S localhost:8004
```
Open `http://localhost:8004/sqli_defense.php` and use the modes/inputs provided by the script.

## Recommended tests
| Test | Expected behavior |
|---|---|
| Safe mode with `alice` | One matching sample user |
| Unsafe mode with `' OR '1'='1` | Demonstrates injection effect |
| Safe mode with `' OR '1'='1` | Does not return all users |

## Validation status
PHP syntax passed. The validation environment had PDO but lacked `pdo_sqlite`; database execution and the three behavior tests were therefore not confirmed. Enable `pdo_sqlite` in the PHP configuration used by XAMPP, restart the PHP process, verify with `php -m`, and run the tests.

## Security warning and limitations
Unsafe mode is intentionally vulnerable and must never be deployed publicly. Use prepared statements in real applications. The in-memory database is recreated each run and does not provide persistent user management.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
