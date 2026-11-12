# Assignment 08 — Password Generator and SHA-256 Hasher
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** Python  
**Main file:** `password_generator_sha256.py`

## Overview
Generates random passwords and calculates SHA-256 digests for text input using Python's standard library.

## Requirements
- Python 3
- Standard modules: `secrets`, `string`, `hashlib`
- No third-party packages

## Features and implementation
- Uses `secrets` for cryptographically strong random character selection.
- Uses uppercase, lowercase, numeric, and symbol character groups.
- Enforces a minimum password length of four characters.
- Converts text to bytes with `.encode()`.
- Calculates the digest using `hashlib.sha256(...)` and displays it with `.hexdigest()`.

## Project structure
```text
Assignment_08/
└── password_generator_sha256.py
```

## Run
```bash
python password_generator_sha256.py
```
Windows:
```powershell
py password_generator_sha256.py
```
Follow the prompts to generate a password and calculate a hash.

## Validation status
Syntax was checked. Lengths 4, 8, 16, and 32 were exercised. The SHA-256 known vector for `abc` was checked, and the program was run successfully.

## Security note
Plain SHA-256 is not suitable for production password storage. Use a password-hashing algorithm such as Argon2id or bcrypt with appropriate parameters. Treat generated passwords as secrets and do not commit them to source control.

## Limitations
This is an educational utility, not a password manager or account-storage system. SHA-256 is deterministic: identical input produces an identical digest.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
