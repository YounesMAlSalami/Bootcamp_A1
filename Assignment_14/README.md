# Assignment 14 — DOM Interaction and DOM-Based XSS Prevention
**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Languages:** HTML, CSS, JavaScript  
**Main file:** `dom_xss_protection.html`

## Overview
A client-side demonstration of the difference between inserting user input with `innerHTML` and inserting it as plain text with `textContent`. The interface includes a text area and controls for unsafe rendering, safe rendering, inserting a test payload, and clearing the output.

## Requirements
- Modern web browser (Chrome, Edge, or Firefox)
- No server, database, package manager, or third-party libraries required

## Project structure
```text
Assignment_14/
└── dom_xss_protection.html
```

## How it works
Unsafe rendering:
```javascript
output.innerHTML = userInput.value;
```
The browser parses the value as HTML. Untrusted markup can introduce dangerous elements or event handlers.

Safe rendering:
```javascript
output.textContent = userInput.value;
```
The browser treats the value as text instead of parsing it as HTML.

The input is read through `document.getElementById().value`, and button actions are registered with `addEventListener()`.

## How to run
1. Download `dom_xss_protection.html`.
2. Open it directly in a modern browser.
3. No local server is required.
4. Enter a value and select the rendering method.

## Recommended tests
Payload:
```html
<img src=x onerror=alert(1)>
```
- Select Unsafe Display: the broken image's `onerror` handler should display an alert in the local demonstration.
- Select Safe Display: the payload should appear literally as text, without executing.
- Also test `<h2>Hello World</h2>`: unsafe rendering interprets it as a heading; safe rendering displays the markup characters.

## Validation status
The HTML file was created with the required interface and JavaScript behavior. Browser execution on the user's device was not confirmed in the documented validation. Perform both payload tests and inspect the browser Console before submission.

## Security warning and limitations
The unsafe button is intentionally vulnerable for classroom demonstration. Keep the page local and do not deploy it publicly. Never insert untrusted data with `innerHTML` in a real application unless it has been sanitized with a suitable, maintained HTML sanitizer. Prefer `textContent`, `document.createElement()`, and `appendChild()` for safe DOM construction.

## Author
Younes Al-Salami — Cybersecurity Programming Bootcamp
