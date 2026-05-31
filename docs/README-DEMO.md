# Hướng Dẫn Chạy Demo Laravel Boost

Tài liệu này chỉ nhằm giúp bạn mở project demo để quan sát Laravel Boost trong bối cảnh một codebase thật. Đây **không phải** tài liệu hướng dẫn xây dựng toàn bộ hệ thống seminar từ đầu.

Khi học hoặc thuyết trình, hãy xem đây là:

- hướng dẫn mở demo
- hướng dẫn kiểm tra luồng code
- hướng dẫn xem Boost được minh hoạ như thế nào trong một repo thật

## Các phần trong demo và ý nghĩa của chúng

Các màn hình dưới đây **không phải trọng tâm seminar**. Chúng chỉ là dữ liệu và luồng minh hoạ để Laravel Boost có ngữ cảnh thật:

- Đăng nhập theo vai trò `admin`, `lecturer`, `student` -> minh hoạ phân quyền và ngữ cảnh người dùng
- Dashboard tổng quan -> minh hoạ dữ liệu đầu vào cho AI và code analytics
- Quản lý topic seminar -> minh hoạ route, controller, model và dữ liệu quan hệ
- Tìm kiếm và lọc topic -> minh hoạ query và luồng request
- Student đăng ký topic -> minh hoạ validation và workflow
- Upload báo cáo -> minh hoạ file handling và review flow
- Lecturer review báo cáo -> minh hoạ luồng xử lý nghiệp vụ
- Gửi yêu cầu chỉnh sửa hoặc chấp nhận báo cáo -> minh hoạ trạng thái dữ liệu
- Lên lịch bảo vệ -> minh hoạ dữ liệu liên kết giữa các bảng
- Chấm điểm và ghi chú -> minh hoạ cập nhật dữ liệu cuối luồng
- Activity logs -> minh hoạ logging và quan sát hệ thống
- AI chat hỗ trợ demo -> minh hoạ chỗ Boost và knowledge base phát huy tác dụng
- Admin quản lý user -> minh hoạ phân quyền quản trị
- Trang in tóm tắt topic -> minh hoạ xuất báo cáo / preview

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

1. Đăng nhập bằng `lecturer` để xem cách code bảo vệ màn hình theo role.
2. Mở topic list hoặc tạo topic để thấy route, controller và form hoạt động.
3. Đăng nhập bằng `student` để xem dữ liệu thay đổi theo quyền.
4. Đăng ký topic để quan sát validation và trạng thái dữ liệu.
5. Upload báo cáo để xem file handling và review flow.
6. Quay lại `lecturer` để review báo cáo và xem vòng phản hồi.
7. Lên lịch bảo vệ và chấm điểm để thấy luồng dữ liệu cuối.
8. Mở dashboard và AI chat để thấy chỗ Laravel Boost được minh hoạ rõ nhất.

## Nếu AI chat không dùng OpenAI

Project vẫn chạy được ở chế độ demo cục bộ.

Điều này là bình thường nếu chưa cấu hình:

```env
OPENAI_API_KEY=...
```

Khi không có khóa OpenAI, chatbot sẽ dùng cơ sở tri thức nội bộ để trả lời.

Trong cả hai trường hợp, mục tiêu vẫn là minh hoạ Laravel Boost, không phải chứng minh một sản phẩm AI thương mại.

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
