# Assignment 12 — Secure File Upload System
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** PHP  
**Main file:** `secure_file_upload.php`

## Overview
A PHP upload handler using Defense-in-Depth. It validates upload status, size, extension, and detected MIME type, then assigns a cryptographically random filename and moves the file to a designated storage directory.

## Requirements
- PHP 8.x recommended
- Fileinfo extension enabled
- XAMPP/Apache or PHP built-in server
- Writable storage directory

## Project structure
```text
Assignment_12/
├── secure_file_upload.php
└── uploads/  (created by the application)
```

## Security controls
1. Reads the upload through `$_FILES['uploaded_file']`.
2. Checks the upload error status.
3. Enforces a 5 MB maximum size.
4. Uses `pathinfo()` and a strict extension allowlist: JPG, JPEG, PNG, PDF.
5. Uses `finfo_file()` to inspect actual content MIME type.
6. Generates a filename with `bin2hex(random_bytes(16))`.
7. Moves the upload using `move_uploaded_file()`.
8. Adds an Apache `.htaccess` protection mechanism in the upload directory.

## Run with XAMPP
From the folder containing the PHP file:
```powershell
C:\xampp\php\php.exe -S localhost:8001
```
Open `http://localhost:8001/secure_file_upload.php` and submit a file using the form.

## Recommended tests
| Test | Expected result |
|---|---|
| Valid JPG | Accepted |
| Valid PNG | Accepted |
| Valid PDF | Accepted |
| PHP file | Rejected |
| PHP content renamed to `.jpg` | Rejected by MIME inspection |
| File larger than 5 MB | Rejected |

For the extension-spoofing test, create a harmless PHP file, rename it to `test.jpg`, and try uploading it in the local lab. The content inspection should reject it.

## Validation status
The solution file was prepared for the assignment. End-to-end upload tests on the user's XAMPP installation were not confirmed in the documented validation. Complete the positive and negative tests before submission.

## Security considerations and limitations
MIME inspection is not malware scanning. Production systems should consider scanning, re-encoding images, authentication, quotas, and storing uploads outside the web root. `.htaccess` protection depends on Apache configuration and does not apply to every server. On Windows, configure folder permissions through Windows security settings.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
