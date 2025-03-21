import socket
from urllib.parse import urlparse
import argparse

def parse_url(url):
    parsed = urlparse(url)
    hostname = parsed.hostname
    port = parsed.port if parsed.port else 80
    path = parsed.path if parsed.path else "/"
    if parsed.query:
        path = f"{path}?{parsed.query}"
    print(f"Hostname: {hostname}")
    print(f"Port: {port}")
    print(f"Path: {path}")
    return hostname, port, path

def extract_title(html_content):
    import re
    import html
    title_match = re.search(r'<title>(.*?)</title>', html_content, re.IGNORECASE | re.DOTALL)
    if title_match:
        title = title_match.group(1).strip()
        title = html.unescape(title)
        return title
    return "Không tìm thấy tiêu đề"

def main(url):
    try:
        hostname, port, path = parse_url(url)
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.connect((hostname, port))
        
        request = (
            f"GET {path} HTTP/1.1\r\n"
            f"Host: {hostname}\r\n"
            "Accept: text/html\r\n"
            "Connection: close\r\n\r\n"
        )
        s.send(request.encode())
        
        full_response = b''
        while True:
            data = s.recv(4096)
            if not data:
                break
            full_response += data
            
        response_text = full_response.decode('utf-8', errors='ignore')
        
        if "301 Moved Permanently" in response_text:
            print("Phát hiện chuyển hướng 301:")
            headers = response_text.split('\r\n')
            for header in headers:
                if header.startswith('Location:'):
                    new_url = header.split(': ')[1]
                    print(f"Đang chuyển hướng đến: {new_url}")
                    return main(new_url)
        
        if '\r\n\r\n' in response_text:
            body = response_text.split('\r\n\r\n', 1)[1]
            title = extract_title(body)
            print(f"Tiêu đề trang: {title}")
        else:
            print("Không thể tìm thấy nội dung trang")
        
    except Exception as e:
        print(f"Lỗi: {e}")
    finally:
        if 's' in locals():
            s.close()

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Script lấy dữ liệu từ URL qua socket.")
    parser.add_argument('--url', required=True, help="URL cần xử lý (ví dụ: http://example.com)")
    
    args = parser.parse_args()
    
    main(args.url)

