# Cơ Sở Tri Thức Cho AI Chat

File này mô tả dữ liệu tri thức nội bộ mà AI chat sử dụng trong dự án.

## Mục đích

Project không huấn luyện model mới.

Thay vào đó, nó dùng một cơ sở tri thức nhỏ, được chọn lọc, để AI:

- hiểu đúng ngữ cảnh seminar
- trả lời bám dự án
- hoạt động được ngay cả khi không có khóa OpenAI

## AI chat biết những gì?

- Seminar Manager là ứng dụng Laravel cho luồng seminar
- giao diện là mô hình lai Blade + React
- React dùng chủ yếu cho dashboard analytics và AI chat
- hệ thống có 3 role chính: admin, lecturer, student
- bảng trung tâm là `registrations`
- các bảng liên quan là `submissions`, `presentations`, `scores`, `activity_logs`

## AI chat có thể trả lời gì?

- dự án này làm gì
- đăng ký seminar hoạt động ra sao
- báo cáo được review thế nào
- điểm số được công bố thế nào
- mỗi role làm gì
- dashboard dùng React ở đâu
- database trông như thế nào

## Khi không có khóa OpenAI

AI chat sẽ dùng cơ sở tri thức cục bộ.

Kết quả:

- vẫn trả lời được
- không phụ thuộc internet
- dễ demo trong lớp

## Khi có khóa OpenAI

Prompt sẽ được bơm thêm khối tri thức của dự án.

Kết quả:

- câu trả lời vẫn bám project thật
- AI ít bịa hơn
- ngữ cảnh ổn định hơn

## Kết luận

Đây không phải pipeline học máy.

Đây là lớp tri thức dự án giúp AI chat hiểu đúng Seminar Manager.

