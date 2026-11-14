# 🛡️ Assignment 14 — DOM Interaction and DOM-Based XSS Prevention

**Author:** Younes Al-Salami  
**Track:** Cybersecurity Programming Bootcamp | **Languages:** HTML, CSS, JavaScript  
**Main File:** `dom_xss_protection.html`

---

## 📖 Overview

A client-side demonstration of the difference between inserting user input with `innerHTML` and inserting it as plain text with `textContent`.

The interface includes a text area and controls for unsafe rendering, safe rendering, inserting a test payload, and clearing the output.

---

## ✨ Key Features

- **Interactive DOM Manipulation:** Allows users to enter text or HTML and observe how the browser handles it.
- **❌ Unsafe Rendering:** Uses `innerHTML` to demonstrate how untrusted HTML input can be interpreted and executed by the browser.
- **✅ Safe Rendering:** Uses `textContent` to display user input as plain text without interpreting it as HTML.
- **XSS Test Payload:** Includes a sample payload to demonstrate an event-handler-based XSS scenario.
- **Output Control:** Provides buttons to insert the test payload, display input safely or unsafely, and clear the output.

---

## 📂 Project Structure

```text
Assignment_14/
├── dom_xss_protection.html       # Main application (HTML, CSS, JavaScript)
├── unsafe mode(1).png            # Screenshot showing JavaScript alert execution
├── safe mode(1).png              # Screenshot showing safe text rendering
└── README.md                     # Project documentation
```

---

## ⚙️ Requirements

- Modern web browser (Chrome, Edge, or Firefox)
- No server, database, package manager, or third-party libraries required

---

## 🚀 Installation & Usage

### 1. Open the Project

Locate the project directory:

```text
Assignment_14/
```

### 2. Open the HTML File

Open the following file directly in a modern web browser:

```text
dom_xss_protection.html
```

### 3. Enter the Test Payload

Use the following payload:

```html
<img src=x onerror=alert(1)>
```

### 4. Compare the Rendering Methods

- Select **Unsafe Display** to observe how the browser interprets the input as HTML.
- Select **Safe Display** to observe how the same input is displayed as plain text.
- Use **Clear** to reset the output.

---

## 🧪 Demonstration & Test Cases

### Test Payload

```html
<img src=x onerror=alert(1)>
```

### Recommended Test Matrix

| Rendering Method | Input | Expected Behavior | Security Outcome |
| :--- | :--- | :--- | :--- |
| **Unsafe Display** | `<img src=x onerror=alert(1)>` | The browser processes the HTML, and the `onerror` event executes JavaScript. | **Vulnerable (DOM XSS)** |
| **Safe Display** | `<img src=x onerror=alert(1)>` | The payload appears as literal text without executing JavaScript. | **Protected** |
| **Unsafe Display** | `<h2>Hello World</h2>` | The browser interprets the input as an HTML heading. | HTML interpreted |
| **Safe Display** | `<h2>Hello World</h2>` | The browser displays the HTML markup as ordinary text. | HTML not interpreted |

---

## 📸 Screenshots

### Main Application Interface

The application provides an interactive input field, rendering controls, and an output area for comparing unsafe and safe DOM manipulation.

![Main Application Interface](dom_xss_protection.html)

### ❌ Unsafe Display — DOM-Based XSS Execution

The test payload is processed using `innerHTML`. The browser interprets the injected HTML, causing the `onerror` event handler to execute and display a JavaScript alert.

![Unsafe Display](unsafe%20mode%281%29.png)

*The screenshot demonstrates JavaScript execution through an injected HTML event handler.*

### ✅ Safe Display — XSS Prevention

The same payload is processed using `textContent`. Instead of interpreting the input as HTML, the browser displays it as ordinary text.

![Safe Display](safe%20mode%281%29.png)

*The payload is displayed literally, and the JavaScript event handler is not executed.*

### Side-by-Side Comparison

| ❌ Unsafe Display (`innerHTML`) | ✅ Safe Display (`textContent`) |
| :--- | :--- |
| HTML input is interpreted by the browser. | HTML input is treated as plain text. |
| Event handlers can execute JavaScript. | Event handlers are not executed. |
| ![Unsafe Result](unsafe%20mode%281%29.png) | ![Safe Result](safe%20mode%281%29.png) |

---

## 🛡️ Security Takeaway

Never insert untrusted user input directly into the DOM using `innerHTML`.

When user-controlled data is inserted as HTML, an attacker may inject elements and event handlers that execute JavaScript in the context of the application.

Prefer **`textContent`** when displaying user-provided text. For applications that genuinely need to render HTML, use a suitable, maintained HTML sanitization library before insertion.

---

## ⚠️ Disclaimer

This tool is developed strictly for **educational purposes and authorized security training**. The unsafe rendering option is intentionally vulnerable to demonstrate DOM-Based XSS behavior. Keep the demonstration local and do not deploy the vulnerable functionality publicly.

---

## 👨‍💻 Author

**Younes Al-Salami**  
Cybersecurity Programming Bootcamp
