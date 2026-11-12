# Assignment 09 — File Integrity Monitoring (FIM)
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** Python  
**Main file:** `file_integrity_monitor.py`

## Overview
Calculates SHA-256 hashes of monitored files, stores a baseline, and compares later hashes to identify file modifications or deletions.

## Requirements
- Python 3
- Standard modules: `hashlib`, `time` and filesystem functions used by the script
- No third-party packages

## How it works
1. Reads monitored files in binary mode.
2. Calculates SHA-256 in 4096-byte chunks.
3. Stores initial hashes as a baseline.
4. Rechecks files in a continuous loop at a 3-second interval.
5. Compares current state with the baseline and reports changes or deletions.
6. Ctrl+C stops the monitoring loop.

## Project structure
```text
Assignment_09/
└── file_integrity_monitor.py
```

## Run
```bash
python file_integrity_monitor.py
```
Windows:
```powershell
py file_integrity_monitor.py
```
Configure the monitored path in the script if necessary and ensure the process can read the target files.

## Recommended manual test
1. Create a disposable test file in the monitored directory.
2. Start the monitor and allow it to create its baseline.
3. Modify the file and wait for the next check.
4. Confirm a modification alert.
5. Delete the file and confirm a deletion alert.
6. Stop with Ctrl+C.

## Validation status
Syntax passed. The hash function and before/after hash comparison were tested successfully. A complete live test of the continuous loop and its alert output was not confirmed; perform the manual test above before submission.

## Limitations and safe use
A local baseline is not tamper-proof if an attacker can change it. Hashes identify content changes but do not identify who made them. This is an educational FIM tool, not an enterprise endpoint security product. Monitor only authorized files.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
