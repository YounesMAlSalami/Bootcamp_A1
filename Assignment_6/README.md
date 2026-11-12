# Assignment 06 — Banner Grabbing Tool
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Language:** Python  
**Main file:** `banner_grabbing_tool.py`

## Overview
A basic TCP banner-grabbing utility that connects to a specified host and port, receives service responses, and displays available banner information. It demonstrates TCP sockets, timeouts, byte decoding, and a simple HTTP HEAD request.

## Requirements
- Python 3
- Network access to the authorized target
- No third-party packages

## How it works
1. Creates a TCP socket and configures a timeout.
2. Connects to the specified host and port.
3. Receives up to 1024 bytes.
4. Decodes the response and separates it into lines.
5. For web services, sends an HTTP HEAD request and reads the response.
6. Handles connection and timeout errors.

## Project structure
```text
Assignment_06/
└── banner_grabbing_tool.py
```

## Run
```bash
python banner_grabbing_tool.py
```
Windows alternative:
```powershell
py banner_grabbing_tool.py
```
Follow the program prompts and use only a host and port you are authorized to test.

## Example use cases
- Inspect an SSH service identification banner.
- Inspect an FTP greeting.
- Review HTTP response headers from a web server.

## Validation status
Python syntax was checked. A connection to an external target was not verified during the documented validation. Actual results depend on service availability, network access, and firewall rules.

## Limitations and safe use
Some services do not send a banner until they receive a protocol-specific request. A banner is an identification clue, not proof of a version or vulnerability. Use only against systems you own or are authorized to assess.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
