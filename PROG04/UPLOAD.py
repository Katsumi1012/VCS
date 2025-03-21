import socket
import urllib.parse
import os
import random
import string
import argparse
import re

def get_args():
    parser = argparse.ArgumentParser()
    parser.add_argument("--url", default="http://192.168.159.129")
    parser.add_argument("--username", default="admin")
    parser.add_argument("--password", default="bv27!sn92X0pVCtsC&")
    parser.add_argument("--localfile", default="./test.jpg")
    return parser.parse_args()

def get_domain(url):
    domain = ""
    if url.startswith("https://"):
        url = url[8:]
    elif url.startswith("http://"):
        url = url[7:]
    domain = url.split('/')[0]
    return domain

def recvall(sock):
    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk
    return response

def get_cookies_from_response(response_text):
    cookies = {}
    for line in response_text.split('\r\n'):
        if line.startswith('Set-Cookie:'):
            cookie_parts = line[11:].strip().split(';')[0].split('=', 1)
            if len(cookie_parts) == 2:
                cookies[cookie_parts[0]] = cookie_parts[1]
    return cookies

def format_cookies(cookies):
    return '; '.join([f"{key}={value}" for key, value in cookies.items()])

def get_wp_nonce(cookies_header, host, wp_path):
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.settimeout(10)
    sock.connect((host, 80))
    
    headers = (
        f"GET {wp_path}/wp-admin/media-new.php HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        f"Cookie: {cookies_header}\r\n"
        "Connection: close\r\n\r\n"
    )
    
    sock.sendall(headers.encode())
    response = recvall(sock)
    sock.close()
    
    response_text = response.decode(errors="ignore")
    match = re.search('name="_wpnonce" value="([a-f0-9]+)"', response_text)
    if match:
        return match.group(1)
    else:
        print("Không tìm thấy WordPress nonce")
        return None

def upload_image(cookies_header, host, wp_path, file_name, file_path):
    wp_nonce = get_wp_nonce(cookies_header, host, wp_path)
    if not wp_nonce:
        return False
    
    file_ext = os.path.splitext(file_name)[1][1:].lower()
    content_type = f"image/{file_ext}"
    
    with open(file_path, 'rb') as img_file:
        image_data = img_file.read()
    
    boundary = '----WebKitFormBoundary' + ''.join(random.choice(string.ascii_letters + string.digits) for _ in range(16))
    
    upload_payload = (
        f'--{boundary}\r\n'
        f'Content-Disposition: form-data; name="name"\r\n\r\n'
        f'{file_name}\r\n'
        f'--{boundary}\r\n'
        f'Content-Disposition: form-data; name="action"\r\n\r\n'
        f'upload-attachment\r\n'
        f'--{boundary}\r\n'
        f'Content-Disposition: form-data; name="_wpnonce"\r\n\r\n'
        f'{wp_nonce}\r\n'
        f'--{boundary}\r\n'
        f'Content-Disposition: form-data; name="async-upload"; filename="{file_name}"\r\n'
        f'Content-Type: {content_type}\r\n\r\n'
    ).encode() + image_data + f'\r\n--{boundary}--\r\n'.encode()
    
    upload_headers = (
        f"POST {wp_path}/wp-admin/async-upload.php HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        f"Cookie: {cookies_header}\r\n"
        f"Content-Type: multipart/form-data; boundary={boundary}\r\n"
        f"Content-Length: {len(upload_payload)}\r\n"
        "Connection: close\r\n\r\n"
    )
    
    upload_request = upload_headers.encode() + upload_payload
    
    upload_sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    upload_sock.settimeout(30)
    upload_sock.connect((host, 80))
    upload_sock.sendall(upload_request)
    
    upload_response = recvall(upload_sock)
    upload_sock.close()
    
    upload_response_text = upload_response.decode(errors="ignore")
    
    if "HTTP/1.1 200 OK" in upload_response_text and "{\"success\":true" in upload_response_text:
        print(f"Hình ảnh {file_name} đã được tải lên thành công")
        match = re.search(r'"url":"([^"]+)"', upload_response_text)
        if match:
            url = match.group(1).replace('\\', '')
            print(f"URL hình ảnh: {url}")
        return True
    else:
        print("Tải lên hình ảnh thất bại")
        return False

def main():
    args = get_args()
    
    full_url = args.url
    host = get_domain(full_url)
    wp_path = ""
    
    if '/' in full_url[8:] if full_url.startswith('https://') else full_url[7:]:
        path_parts = full_url.split('/', 3)[3:]
        if path_parts:
            wp_path = '/' + path_parts[0]
    
    user = urllib.parse.quote(args.username)
    password = urllib.parse.quote(args.password)
    file_path = args.localfile
    file_name = os.path.basename(file_path)
    
    login_path = f"{wp_path}/wp-login.php"
    
    payload = f"log={user}&pwd={password}&wp-submit=Log+In"
    headers = (
        f"POST {login_path} HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        "Content-Type: application/x-www-form-urlencoded\r\n"
        f"Content-Length: {len(payload)}\r\n"
        "Connection: keep-alive\r\n\r\n"
    )
    
    request = headers + payload
    
    try:
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.settimeout(10)
        sock.connect((host, 80))
        
        sock.sendall(request.encode())
        response = recvall(sock)
        sock.close()
        
        response_text = response.decode(errors="ignore")
        
        cookies = get_cookies_from_response(response_text)
        cookies_header = format_cookies(cookies)
        
        if ("login_error" in response_text and "The password you entered for the username" in response_text):
            print(f"User {user} đăng nhập thất bại")
        elif "wordpress_logged_in" in response_text or any("wordpress_logged_in" in key for key in cookies):
            print(f"User {user} đăng nhập thành công")
            
            upload_image(cookies_header, host, wp_path, file_name, file_path)
        else:
            print("Không thể xác định kết quả đăng nhập")
    
    except Exception as e:
        print(f"Lỗi kết nối: {e}")

if __name__ == "__main__":
    main()
