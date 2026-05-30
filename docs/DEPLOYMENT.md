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

## 6. Nếu dùng SQL Server

Project có thể chạy với SQL Server.

Trong `.env` thường dùng:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=seminar_manager
DB_USERNAME=sa
DB_PASSWORD=your_password
DB_ENCRYPT=false
DB_TRUST_SERVER_CERTIFICATE=true
SESSION_DRIVER=file
CACHE_STORE=file
```

Điều cần nhớ:

- phải cài `sqlsrv` và `pdo_sqlsrv`
- SQL Server service phải đang chạy
- database `seminar_manager` phải tồn tại

## 7. OpenAI cho AI chat

Nếu muốn chatbot dùng OpenAI thật:

```env
OPENAI_API_KEY=your_key_here
OPENAI_MODEL=gpt-4.1-mini
OPENAI_BASE_URL=https://api.openai.com/v1
```

Nếu không có key, chatbot vẫn chạy ở chế độ demo cục bộ.

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
- kiểm tra SQL Server hoặc database đang chạy

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
5. mở dashboard và demo luồng seminar
