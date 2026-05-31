# Hướng Dẫn Chạy Và Triển Khai

Tài liệu này chỉ giữ những bước cần thiết để chạy demo và hiểu cách deploy.

## 1. Yêu cầu tối thiểu

- PHP 8.4
- Composer
- Node.js + npm
- Database tương thích Laravel

## 2. Cài dependencies

```bash
composer install
npm install
```

## 3. Tạo file môi trường

```bash
copy .env.example .env
php artisan key:generate
```

## 4. Chạy database demo

```bash
php artisan migrate:fresh --seed
```

## 5. Chạy giao diện và backend

```bash
npm run dev
php artisan serve
```

Mở:

- `http://127.0.0.1:8000`

Nếu `php` trên máy của bạn trỏ nhầm sang bản cũ, dùng PHP 8.4 trực tiếp:

```powershell
& "C:\Users\Voduybinhv\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" artisan serve --host=127.0.0.1 --port=8002
```

Mở thay thế:

- `http://127.0.0.1:8002`

## 6. Cấu hình database cho demo

Với buổi seminar, nên ưu tiên **SQLite** để chạy nhanh và ít lỗi môi trường.

Trong `.env` dùng:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
SESSION_DRIVER=file
CACHE_STORE=file
```

Điều cần nhớ:

- file `database/database.sqlite` đã có sẵn trong project
- không cần cài driver SQL Server cho chế độ demo local
- nếu muốn đổi sang SQL Server sau này thì mới cần cấu hình thêm `sqlsrv`

Ghi chú cho Windows:
- nếu file SQLite trong thư mục project bị lỗi I/O, có thể chuyển `DB_DATABASE` sang một file trong `C:/Users/<you>/AppData/Local/Temp/`

## 7. OpenAI cho AI chat

Nếu muốn chatbot dùng OpenAI thật:

```env
OPENAI_API_KEY=your_key_here
OPENAI_MODEL=gpt-4.1-mini
OPENAI_BASE_URL=https://api.openai.com/v1
```

Nếu không có key, chatbot vẫn chạy ở chế độ demo cục bộ. Với seminar, đây là chế độ khuyến nghị vì ổn định hơn và không phụ thuộc billing/quota.

## 8. Checklist deploy cơ bản

Trước khi đưa lên môi trường thật:

- đặt `APP_ENV=production`
- đặt `APP_DEBUG=false`
- chạy `php artisan migrate --force`
- build giao diện bằng `npm run build`
- tạo storage link nếu cần file upload
- cấu hình mail driver nếu muốn gửi email thật

## 9. Lỗi hay gặp

### Không vào được login

- kiểm tra database đã migrate chưa
- kiểm tra session driver
- kiểm tra file SQLite `database/database.sqlite` còn tồn tại

### AI chat lỗi

- kiểm tra `OPENAI_API_KEY`
- nếu không có key thì dùng chế độ demo cục bộ

### React không hiện

- chạy `npm run dev`
- hoặc build lại tài nguyên giao diện

## 10. Kết luận ngắn

Với seminar, bạn chỉ cần:

1. cài dependencies
2. cấu hình `.env`
3. migrate + seed
4. chạy Laravel
5. mở dashboard và `AI Chat`
6. ưu tiên local demo mode nếu muốn demo AI ổn định
