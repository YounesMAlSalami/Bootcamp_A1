
import socket

target = "google.com"
ip = socket.gethostbyname(target)

print("Target IP:", ip)

for port in [1, 53, 80, 443, 445]:
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.settimeout(3)

    result = s.connect_ex((ip, port))

    print(f"Port {port}: Return Code = {result}")

    s.close()
