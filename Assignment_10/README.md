# Assignment 10 — PHP HTTP REST API
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** PHP  
**Main file:** `http_rest_api.php`

## Overview
A small PHP HTTP endpoint that reads the request method, inspects headers, parses JSON from `php://input`, and returns JSON responses for GET, POST, PUT, and DELETE. Unsupported methods and malformed JSON are handled with HTTP error status codes.

## Requirements
- PHP 8.x recommended
- XAMPP or PHP built-in development server
- `curl.exe` for command-line testing; Postman is optional
- No database is used

## Project structure
```text
Assignment_10/
└── http_rest_api.php
```

## How it works
- Reads the method through `$_SERVER['REQUEST_METHOD']`.
- Reads request headers and checks whether Authorization was provided.
- Reads the raw body through `php://input`.
- Parses JSON using `json_decode()`.
- Routes methods with `switch`.
- Returns JSON using `json_encode()` and appropriate status codes.

## Run with XAMPP PHP
From the directory containing the file:
```powershell
C:\xampp\php\php.exe -S localhost:8000
```
Open `http://localhost:8000/http_rest_api.php`. Keep the server terminal running. If PHP is on PATH, `php -S localhost:8000` also works.

## Test with curl on Windows
GET:
```powershell
curl.exe -i -X GET "http://localhost:8000/http_rest_api.php"
```
POST:
```powershell
curl.exe -i -X POST "http://localhost:8000/http_rest_api.php" -H "Content-Type: application/json" -d "{\"username\":\"Younes\",\"email\":\"younes@example.com\"}"
```
PUT:
```powershell
curl.exe -i -X PUT "http://localhost:8000/http_rest_api.php" -H "Content-Type: application/json" -d "{\"username\":\"Younes Updated\",\"email\":\"updated@example.com\"}"
```
DELETE:
```powershell
curl.exe -i -X DELETE "http://localhost:8000/http_rest_api.php"
```
Unsupported method:
```powershell
curl.exe -i -X PATCH "http://localhost:8000/http_rest_api.php"
```
Malformed JSON:
```powershell
curl.exe -i -X POST "http://localhost:8000/http_rest_api.php" -H "Content-Type: application/json" -d "{invalid json}"
```

## Expected status codes
| Case | Expected |
|---|---:|
| GET | 200 |
| POST | 201 |
| PUT | 200 |
| DELETE | 200 |
| Unsupported method | 405 |
| Invalid JSON | 400 |

## Validation status
PHP syntax passed. The local PHP server was started and GET, POST, PUT, DELETE, PATCH, and malformed-JSON cases were tested; observed behavior matched the implemented status handling.

## Security and limitations
Checking whether an Authorization header exists is not authentication; a real API must validate credentials and permissions. Use HTTPS, validate input, and add rate limiting and persistent storage for production. This assignment has no database, so CRUD responses are demonstrations rather than persistent data operations.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
