import hashlib
import os
import time
from datetime import datetime


def calculate_hash(file_path):
    sha256 = hashlib.sha256()

    with open(file_path, "rb") as file:
        while True:
            chunk = file.read(4096)

            if not chunk:
                break

            sha256.update(chunk)

    return sha256.hexdigest()


def monitor_file(file_path):
    try:
        baseline_hash = calculate_hash(file_path)
    except FileNotFoundError:
        print("Error: File not found.")
        return
    except OSError as error:
        print(f"Error reading file: {error}")
        return

    last_hash = baseline_hash

    print("========== File Integrity Monitoring ==========")
    print(f"File: {os.path.abspath(file_path)}")
    print(f"Baseline SHA-256: {baseline_hash}")
    print("Monitoring started. Press Ctrl+C to stop.")

    try:
        while True:
            time.sleep(3)

            try:
                current_hash = calculate_hash(file_path)
            except FileNotFoundError:
                if last_hash is not None:
                    print(
                        f"[CRITICAL ALERT] File was deleted: "
                        f"{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}"
                    )
                    last_hash = None
                continue
            except OSError as error:
                print(f"[ERROR] Cannot read file: {error}")
                continue

            if current_hash != baseline_hash and current_hash != last_hash:
                print(
                    f"[CRITICAL ALERT] File content has been modified! "
                    f"Time: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}"
                )
                print(f"Baseline Hash: {baseline_hash}")
                print(f"Current Hash:  {current_hash}")

            elif current_hash == baseline_hash and last_hash != baseline_hash:
                print("[INFO] File content has been restored to the baseline.")

            last_hash = current_hash

    except KeyboardInterrupt:
        print("\nMonitoring stopped by user.")


def main():
    file_path = input("Enter file path to monitor: ").strip()

    if not file_path:
        print("Error: File path cannot be empty.")
        return

    monitor_file(file_path)


if __name__ == "__main__":
    main()