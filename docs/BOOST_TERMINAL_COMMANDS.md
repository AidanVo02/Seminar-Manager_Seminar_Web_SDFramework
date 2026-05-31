# Các Lệnh Terminal Liên Quan Laravel Boost

Tài liệu này liệt kê các lệnh terminal hay dùng khi làm việc với Laravel Boost và project demo.

Mục tiêu:

- cài Boost
- kiểm tra Boost
- chạy demo
- reset môi trường
- phục vụ thuyết trình dễ hơn

## 1. Cài Laravel Boost

Nếu chưa có Boost trong project:

```bash
composer require laravel/boost --dev
```

Ý nghĩa:

- thêm package Boost vào `require-dev`
- chỉ dùng cho môi trường phát triển

## 2. Cài đặt Boost vào repo

Sau khi đã có package:

```bash
php artisan boost:install
```

Có thể dùng thêm các cờ tuỳ nhu cầu:

```bash
php artisan boost:install --guidelines --skills --mcp --no-interaction
```

Ý nghĩa:

- sinh file cấu hình và guideline cho agent
- bật MCP
- tạo/điều chỉnh skills theo project

## 3. Khởi động MCP của Boost

```bash
php artisan boost:mcp
```

Ý nghĩa:

- khởi động MCP server của Laravel Boost
- giúp AI agent đọc ngữ cảnh thật của project

## 4. Kiểm tra package và cấu hình

```bash
composer show laravel/boost
```

```bash
php artisan about
```

```bash
php artisan optimize:clear
```

Ý nghĩa:

- xem Boost đã được cài chưa
- xem thông tin app
- xoá cache cấu hình / route / view để tránh dữ liệu cũ

## 5. Chạy demo local

```bash
php artisan migrate:fresh --seed
```

```bash
npm install
```

```bash
npm run dev
```

```bash
php artisan serve
```

Ý nghĩa:

- tạo lại database demo
- cài frontend dependencies
- bật Vite
- bật Laravel server

## 6. Chạy demo theo cách ổn định trên máy này

Nếu `php` trên máy trỏ nhầm sang bản cũ, dùng PHP 8.4 trực tiếp:

```powershell
& "C:\Users\Voduybinhv\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" artisan optimize:clear
```

```powershell
& "C:\Users\Voduybinhv\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" artisan migrate:fresh --seed
```

```powershell
& "C:\Users\Voduybinhv\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" artisan serve --host=127.0.0.1 --port=8002
```

## 7. Kiểm tra test

```bash
php artisan test
```

Hoặc test riêng AI chat:

```bash
php artisan test --filter=AiChatTest --compact
```

Ý nghĩa:

- xác nhận local demo mode vẫn chạy
- xác nhận code Boost demo không bị vỡ

## 8. Chạy lại khi bị lỗi cache

```bash
php artisan optimize:clear
```

```bash
php artisan config:clear
```

```bash
php artisan route:clear
```

```bash
php artisan view:clear
```

## 9. Các lệnh hữu ích khi demo

```bash
php artisan route:list
```

```bash
php artisan tinker
```

```bash
php artisan pail
```

```bash
php artisan queue:listen --tries=1 --timeout=0
```

Ý nghĩa:

- `route:list` để xem route nào đang có
- `tinker` để thử query / model nhanh
- `pail` để xem log
- `queue:listen` để chạy job nếu project cần

## 10. Lệnh dừng dự án

Nếu mở từ terminal:

- nhấn `Ctrl + C` ở terminal Laravel
- nhấn `Ctrl + C` ở terminal Vite

Nếu bị treo tiến trình:

```powershell
Get-Process php,node -ErrorAction SilentlyContinue | Stop-Process -Force
```

## 11. Lệnh liên quan OpenAI

Trong project này, AI chat local demo mode là mặc định nên **không bắt buộc** phải có key.

Nếu muốn thử cloud AI thật:

- sửa `.env`
- thêm `OPENAI_API_KEY`

Sau đó:

```bash
php artisan optimize:clear
```

## 12. Bộ lệnh demo gọn nhất

Nếu chỉ cần chạy nhanh để thuyết trình:

```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

Nếu cần thì mở AI chat và hỏi:

- `Laravel Boost là gì?`
- `Boost đã được gắn vào project này ở những file nào?`
- `Khi không có OpenAI key thì chatbot chạy thế nào?`

