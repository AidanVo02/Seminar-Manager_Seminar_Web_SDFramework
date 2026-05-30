# Hướng Dẫn Chạy Demo

Tài liệu này chỉ tập trung vào một việc: làm sao mở project lên và xem được luồng hoạt động chính.

## Tính năng đã có trong demo

- Đăng nhập theo vai trò `admin`, `lecturer`, `student`
- Dashboard tổng quan
- Quản lý topic seminar
- Tìm kiếm và lọc topic
- Student đăng ký topic
- Upload báo cáo
- Lecturer review báo cáo
- Gửi yêu cầu chỉnh sửa hoặc chấp nhận báo cáo
- Lên lịch bảo vệ
- Chấm điểm và ghi chú
- Activity logs
- AI chat hỗ trợ seminar
- Admin quản lý user
- Trang in tóm tắt topic

## Tài khoản demo

- Admin: `admin@seminar.test` / `password`
- Lecturer: `lecturer@seminar.test` / `password`
- Lecturer 2: `lecturer2@seminar.test` / `password`
- Lecturer 3: `lecturer3@seminar.test` / `password`
- Student 1: `student1@seminar.test` / `password`
- Student 2: `student2@seminar.test` / `password`
- Student 3: `student3@seminar.test` / `password`
- Student 4: `student4@seminar.test` / `password`
- Student 5: `student5@seminar.test` / `password`

## Cách chạy nhanh

```bash
composer install
npm install
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

Mở:

- `http://127.0.0.1:8000`

## Luồng demo ngắn

1. Đăng nhập bằng lecturer.
2. Tạo topic mới.
3. Đăng nhập bằng student.
4. Đăng ký topic.
5. Upload báo cáo.
6. Quay lại lecturer.
7. Review báo cáo.
8. Lên lịch bảo vệ.
9. Chấm điểm.
10. Mở dashboard và AI chat.

## Nếu AI chat không dùng OpenAI

Project vẫn chạy được ở chế độ demo cục bộ.

Điều này là bình thường nếu chưa cấu hình:

```env
OPENAI_API_KEY=...
```

Khi không có khóa OpenAI, chatbot sẽ dùng cơ sở tri thức nội bộ để trả lời.

## Lưu ý khi chạy trên máy này

- Nếu giao diện React chưa chạy, phần Laravel vẫn hoạt động bình thường.
- Nếu dữ liệu demo chưa đúng, chạy lại `php artisan migrate:fresh --seed`.
- Nếu cần reset hẳn, chạy lại toàn bộ lệnh cài và seed ở trên.

## Kiểm tra nhanh

- `php artisan test` phải pass
- `php artisan migrate:fresh --seed` phải pass

## Tài liệu liên quan

- `DOCUMENTATION_INDEX.md`
- `PROJECT_OVERVIEW.md`
- `ARCHITECTURE.md`
- `DATABASE.md`
- `BOOST_CODE_TOUR.md`
