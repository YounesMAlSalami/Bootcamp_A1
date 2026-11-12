import re

ATTACK_PATTERNS = {
    "SQL Injection": re.compile(
        r"union(?:\s|%20|\+)+select|"
        r"select(?:\s|%20|\+)+.*(?:\s|%20|\+)from|"
        r"(?:'|%27)(?:\s|%20|\+)*(?:or|and)(?:\s|%20|\+)*"
        r"(?:'|%27)?\w+(?:'|%27)?(?:\s|%20|\+)*(?:=|%3d)"
        r"(?:\s|%20|\+)*(?:'|%27)?\w+",
        re.IGNORECASE
    ),
    "Path Traversal": re.compile(
        r"(?:\.\./|%2e%2e%2f|%2e%2e/|\.\.\\|%2e%2e%5c)",
        re.IGNORECASE
    )
}

IP_PATTERN = re.compile(r"^(\d{1,3}(?:\.\d{1,3}){3})")


def analyze_log(file_path):
    total_lines = 0
    total_alerts = 0
    attack_counts = {attack: 0 for attack in ATTACK_PATTERNS}

    try:
        with open(file_path, "r", encoding="utf-8", errors="replace") as log_file:
            for line_number, line in enumerate(log_file, start=1):
                total_lines += 1
                ip_match = re.search(IP_PATTERN, line)
                attacker_ip = ip_match.group(1) if ip_match else "Unknown IP"

                for attack_name, pattern in ATTACK_PATTERNS.items():
                    if re.search(pattern, line):
                        total_alerts += 1
                        attack_counts[attack_name] += 1
                        print(
                            f"[SECURITY ALERT] Attack: {attack_name} | "
                            f"Line: {line_number} | Attacker IP: {attacker_ip}"
                        )

    except FileNotFoundError:
        print(f"Error: File not found: {file_path}")
        return
    except OSError as error:
        print(f"Error reading file: {error}")
        return

    print("\n========== Scan Summary ==========")
    print(f"Total lines scanned: {total_lines}")
    print(f"Total attacks detected: {total_alerts}")

    for attack_name, count in attack_counts.items():
        print(f"{attack_name}: {count}")


def main():
    print("========== Automated Log Analyzer ==========")
    file_path = input("Enter log file path: ").strip()

    if not file_path:
        print("Error: File path cannot be empty.")
        return

    analyze_log(file_path)


if __name__ == "__main__":
    main()