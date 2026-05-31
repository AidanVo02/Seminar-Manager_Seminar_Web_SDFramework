# Kiến Trúc Dự Án

Tài liệu này giúp bạn hiểu các nhóm file code hoạt động như thế nào.

## 1. Kiến trúc tổng thể

Dự án dùng kiến trúc Laravel truyền thống:

- `routes` -> định tuyến URL
- `controllers` -> xử lý request
- `models` -> mô tả quan hệ dữ liệu
- `views` -> giao diện Blade
- `support` -> các hàm/lớp dùng chung
- `migrations` -> cấu trúc database
- `seeders` -> dữ liệu demo

Ngoài ra, dashboard và AI chat có phần React để tăng tính tương tác.

## 2. Nhóm file quan trọng

### Routes

- `routes/web.php`

Nhiệm vụ:

- khai báo đường dẫn
- gắn middleware
- trỏ request tới controller

### Controllers

Thư mục:

- `app/Http/Controllers`

Nhiệm vụ:

- nhận request
- validate input
- kiểm tra quyền
- đọc/ghi dữ liệu
- trả view hoặc redirect

### Models

Thư mục:

- `app/Models`

Nhiệm vụ:

- định nghĩa bảng dữ liệu
- định nghĩa quan hệ
- giúp query dễ hơn

### Support classes

Thư mục:

- `app/Support`

Nhiệm vụ:

- gom logic dùng chung
- gửi mail
- ghi log
- xử lý AI chat
- chứa cơ sở tri thức

### Views

Thư mục:

- `resources/views`

Nhiệm vụ:

- render UI
- hiển thị form
- hiển thị dashboard
- hiển thị topic detail
- hiển thị AI chat

### React

Thư mục:

- `resources/js`

Nhiệm vụ:

- dashboard analytics
- giao diện AI chat

## 3. Luồng request

Ví dụ một user đăng ký topic:

1. Browser gửi request đến route.
2. Route gọi controller.
3. Controller validate và kiểm tra quyền.
4. Controller đọc/ghi model.
5. Model thao tác với database.
6. Controller trả về view hoặc redirect.

Đây là cách Laravel MVC hoạt động trong dự án này.

## 4. Vì sao registrations là trung tâm

Trong hệ thống seminar, một registration kết nối:

- 1 student
- 1 topic

Sau đó mọi thứ khác bám vào registration:

- submission
- presentation
- score

Nên `registrations` là điểm trung tâm của luồng xử lý.

## 5. Cách AI chat được gắn vào kiến trúc

AI chat không nằm ngoài hệ thống.

Nó đi theo cùng kiến trúc:

- `AiChatController` nhận request
- `SeminarAiChat` tạo câu trả lời
- `SeminarKnowledgeBase` cấp tri thức cục bộ
- `AiChatConversation` và `AiChatMessage` lưu lịch sử

Như vậy AI chat vẫn là một phần của Laravel app, không phải một hệ thống tách rời.

## 6. Ghi nhớ nhanh

Nếu bạn cần nói nhanh với giảng viên:

> Dự án dùng Laravel MVC truyền thống, trong đó routes điều hướng request, controllers xử lý nghiệp vụ, models làm việc với database, support classes gom logic dùng chung, còn React chỉ dùng ở các phần tương tác cao như dashboard và AI chat.

