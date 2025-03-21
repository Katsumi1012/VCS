import socket
import urllib.parse

host = "192.168.159.129"
port = 80
path = "/wp-login.php"

user = urllib.parse.quote("admin")
password = urllib.parse.quote("bv27!sn92X0pVCtsC&")

payload = f"log={user}&pwd={password}&wp-submit=Log+In"
headers = (
    f"POST {path} HTTP/1.1\r\n"
    f"Host: {host}\r\n"
    "Content-Type: application/x-www-form-urlencoded\r\n"
    f"Content-Length: {len(payload)}\r\n"
    "Connection: close\r\n\r\n"
)

request = headers + payload

try:
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.settimeout(10)
    sock.connect((host, port))
    
    sock.sendall(request.encode())
    
    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk
    
    response_text = response.decode(errors="ignore")
    if ("login_error" and "The password you entered for the username <strong>admin</strong> is incorrect") in response_text:
        print(f"User {user} đăng nhập thất bại")
    elif "wordpress_logged_in" in response_text:
        print(f"User {user} đăng nhập thành công")
    else:
        print("Không thể xác định kết quả đăng nhập")

except Exception as e:
    print(f"Lỗi kết nối: {e}")
finally:
    sock.close()
