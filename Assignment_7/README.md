# Assignment 07 — Automated Log Analyzer
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** Python  
**Files:** `automated_log_analyzer.py`, `sample_access.log`

## Overview
Reads web access logs line by line and searches for regular-expression indicators associated with SQL Injection and Path Traversal. Reports suspicious entries with line numbers and IP information where available.

## Requirements
- Python 3
- Access log compatible with the patterns in the script
- No third-party packages

## Detection scope
- SQL Injection indicators in request data.
- Path Traversal indicators in request paths.

A match indicates suspicious input; it does not prove that an attack succeeded.

## How it works
1. Opens the log using `with open(...)`.
2. Reads one line at a time.
3. Checks each line against configured regular expressions.
4. Extracts the line number and IP information where available.
5. Displays alerts and a summary.

## Project structure
```text
Assignment_07/
├── automated_log_analyzer.py
└── sample_access.log
```

## Run
```bash
python automated_log_analyzer.py
```
Windows:
```powershell
py automated_log_analyzer.py
```
Keep `sample_access.log` at the path expected by the script, or update the configured path for another authorized log file.

## Validation status
The analyzer was run against a sample test log and detected 2 SQL Injection indicators and 1 Path Traversal indicator.

## Limitations and safe use
Regex-based detection can produce false positives and false negatives. Encoding, obfuscation, and different log formats may require additional rules. Analyze only logs you are authorized to access and protect logs as potentially sensitive data.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
