import socket
import os

host = "192.168.159.129"
port = 80
path = "/wp-content/uploads/2025/03/images.png"

def create_request(path, host):
    return (
        f"GET {path} HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        "Connection: close\r\n\r\n"
    )

def create_connection(host, port):
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.settimeout(10)
    sock.connect((host, port))
    return sock

def receive_response(sock):
    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk
    return response

def extract_image_data(response):
    header_end = response.find(b"\r\n\r\n")
    if header_end == -1:
        raise ValueError("Không thể tìm thấy phần kết thúc của header")
    return response[header_end + 4:]

def save_image(image_data, filename):
    with open(filename, "wb") as f:
        f.write(image_data)
    return len(image_data)

def download_image():
    try:
        request = create_request(path, host)
        sock = create_connection(host, port)
        
        sock.sendall(request.encode())
        response = receive_response(sock)
        
        image_data = extract_image_data(response)
        filename = os.path.basename(path)
        size = save_image(image_data, filename)
        
        print(f"Đã tải và lưu file: {filename}")
        print(f"Kích thước: {size} bytes")

    except Exception as e:
        print(f"Lỗi: {e}")
    finally:
        sock.close()

if __name__ == "__main__":
    download_image()
