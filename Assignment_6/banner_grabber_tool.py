import socket
import ssl

WEB_PORTS = {80, 8000, 8008, 8080, 8888}
HTTPS_PORTS = {443, 8443}
DEFAULT_PORTS = [21, 22, 25, 80, 110, 143, 443, 3306, 8080]


def get_banner(host, port, timeout=3):
    try:
        connection = socket.create_connection((host, port), timeout=timeout)
        connection.settimeout(timeout)

        try:
            if port in HTTPS_PORTS:
                context = ssl.create_default_context()
                connection = context.wrap_socket(connection, server_hostname=host)

            if port in WEB_PORTS or port in HTTPS_PORTS:
                request = (
                    f"HEAD / HTTP/1.1\r\n"
                    f"Host: {host}\r\n"
                    f"Connection: close\r\n\r\n"
                )
                connection.sendall(request.encode("utf-8"))

            data = connection.recv(1024)

            if not data:
                return "No banner received"

            response = data.decode("utf-8", errors="ignore").strip()
            lines = response.splitlines()

            if not lines:
                return "No banner received"

            first_line = lines[0].strip()
            server_line = next(
                (line.strip() for line in lines if line.lower().startswith("server:")),
                None
            )

            if server_line and server_line.lower() != first_line.lower():
                return f"{first_line} | {server_line}"

            return first_line

        finally:
            connection.close()

    except socket.timeout:
        return "Connection timed out"
    except ConnectionRefusedError:
        return "Connection refused"
    except ssl.SSLError:
        return "SSL/TLS connection error"
    except OSError as error:
        return f"Connection error: {error}"


def read_ports():
    entered_ports = input(
        "Enter ports separated by commas "
        f"(press Enter for {', '.join(map(str, DEFAULT_PORTS))}): "
    ).strip()

    if not entered_ports:
        return DEFAULT_PORTS

    ports = []

    for item in entered_ports.split(","):
        item = item.strip()

        if not item.isdigit():
            raise ValueError(f"Invalid port: {item}")

        port = int(item)

        if not 1 <= port <= 65535:
            raise ValueError(f"Port out of range: {port}")

        if port not in ports:
            ports.append(port)

    return ports


def main():
    print("\n========== Banner Grabbing Tool ==========")
    host = input("Enter target IP or domain: ").strip()

    if not host:
        print("Target cannot be empty.")
        return

    try:
        ports = read_ports()
    except ValueError as error:
        print(error)
        return
    print(f"\n-------------------------------------------------------")
    print(f"Banner Grabbing Report for: {host}")
    print("-" * 55)

    for port in ports:
        print(f"[{port}] Checking service...")
        result = get_banner(host, port)
        print(f"[{port}] {result}")
        print("-" * 55)


if __name__ == "__main__":
    main()