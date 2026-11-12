
import select
import socket
import errno
import time
from concurrent.futures import ThreadPoolExecutor, as_completed


MAX_WORKERS = 50
TIMEOUT = 1

import socket
import errno

TIMEOUT = 5

def scan_port(target_ip, port):
    try:
        with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as client:

            client.setblocking(False)

            result = client.connect_ex((target_ip, port))

            if result == 0:
                return port, "OPEN"

            # Connection is still in progress
            if result in (10035, 10036, 10037):

                _, writable, exceptional = select.select(
                    [], [client], [client], TIMEOUT
                )

                if not writable and not exceptional:
                    return port, "FILTERED"

                error = client.getsockopt(
                    socket.SOL_SOCKET,
                    socket.SO_ERROR
                )

                if error == 0:
                    return port, "OPEN"

                elif error == 10061:
                    return port, "CLOSED"

                elif error == 10060:
                    return port, "FILTERED"

                else:
                    return port, f"ERROR ({error})"

            elif result == 10061:
                return port, "CLOSED"

            elif result == 10060:
                return port, "FILTERED"

            else:
                return port, f"ERROR ({result})"

    except OSError as e:
        return port, f"ERROR ({getattr(e, 'winerror', None) or e.errno})"



def resolve_domain(target):
    for attempt in range(2):
        try:
            results = socket.getaddrinfo(
                target,
                None,
                socket.AF_INET,
                socket.SOCK_STREAM
            )

            return results[0][4][0]

        except socket.gaierror:
            if attempt == 0:
                time.sleep(1)

    return None


# def scan_port(target_ip, port):
#     try:
#         with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as client:
#             client.settimeout(TIMEOUT)

#             result = client.connect_ex((target_ip, port))

#             if result == 0:
#                 return port, "OPEN"

#             elif result == errno.ECONNREFUSED:
#                 return port, "CLOSED"

#             elif result == errno.ETIMEDOUT:
#                 return port, "FILTERED"

#             else:
#                 return port, "ERROR"

#     except OSError:
#         return port, "ERROR"


def main():
    target = input("Enter Target IP or Domain: ").strip()

    if not target:
        print("[-] Target cannot be empty")
        return

    target_ip = resolve_domain(target)

    if target_ip is None:
        print("[-] Could not resolve target. Check DNS or network connection.")
        return

    print(f"\n[+] Target: {target}")
    print(f"[+] IP Address: {target_ip}")
    print("[+] Scanning ports 1-1024...\n")

    start_time = time.perf_counter()

    open_ports = []
    closed_count = 0
    filtered_count = 0
    error_count = 0

    with ThreadPoolExecutor(max_workers=MAX_WORKERS) as executor:

        futures = [
            executor.submit(scan_port, target_ip, port)
            for port in range(1, 1025)
        ]

        for future in as_completed(futures):

            port, status = future.result()

            if status == "OPEN":
                open_ports.append(port)
                print(f"[+] Port {port}: OPEN")

            elif status == "CLOSED":
                closed_count += 1

            elif status == "FILTERED":
                filtered_count += 1

            else:
                error_count += 1

    elapsed_time = time.perf_counter() - start_time

    print("\n========== SCAN RESULTS ==========")

    print(f"[+] Open Ports: {sorted(open_ports)}")
    print(f"[+] Total Open Ports: {len(open_ports)}")
    print(f"[+] Closed Ports: {closed_count}")
    print(f"[+] Filtered Ports: {filtered_count}")
    print(f"[+] Errors: {error_count}")
    print(f"[+] Total Scanned: {1024}")
    print(f"[+] Scan Time: {elapsed_time:.2f} seconds")

    print("==================================")


if __name__ == "__main__":
    main()
