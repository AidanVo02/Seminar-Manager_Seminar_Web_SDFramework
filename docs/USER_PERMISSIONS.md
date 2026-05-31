# Quyền Người Dùng

Tài liệu này giúp bạn hiểu từng vai trò được làm gì và không được làm gì trong hệ thống.

## 1. Guest

Guest là người chưa đăng nhập.

### Có thể làm

- xem trang login

### Không thể làm

- mở dashboard
- xem topic
- đăng ký topic
- upload báo cáo
- dùng AI chat
- quản lý user

## 2. Student

Student là người tham gia seminar.

### Có thể làm

- xem danh sách topic
- tìm kiếm và lọc topic
- đăng ký topic mở
- upload báo cáo
- xem review note
- nộp lại báo cáo
- tải báo cáo của mình
- xoá báo cáo của mình
- xem lịch bảo vệ
- xem điểm
- dùng AI chat

### Không thể làm

- tạo topic
- duyệt đăng ký của người khác
- lên lịch bảo vệ
- chấm điểm
- quản lý user

## 3. Lecturer

Lecturer là người hướng dẫn seminar.

### Có thể làm

- tạo topic
- chỉnh sửa topic mình phụ trách
- xem topic detail
- duyệt hoặc từ chối registration
- review báo cáo
- yêu cầu sửa
- chấp nhận báo cáo
- lên lịch bảo vệ
- chấm điểm
- xem activity logs liên quan
- dùng AI chat

### Không thể làm

- quản lý toàn bộ user
- chỉnh sửa topic của lecturer khác
- xoá dữ liệu ngoài phạm vi được phép

## 4. Admin

Admin là vai trò có quyền rộng nhất.

### Có thể làm

- quản lý user
- tạo/sửa/xoá topic
- duyệt đăng ký
- review báo cáo
- lên lịch bảo vệ
- chấm điểm
- xem toàn bộ dashboard
- xem activity logs
- dùng AI chat

### Không thể làm

- bỏ qua đăng nhập
- sửa code từ giao diện

## 5. Tóm tắt ngắn

| Vai trò | Làm được | Không làm được |
|---|---|---|
| Guest | xem login | vào hệ thống |
| Student | đăng ký, upload, xem kết quả | duyệt/chấm điểm |
| Lecturer | quản lý seminar của mình | quản lý user toàn hệ thống |
| Admin | làm hầu hết tác vụ | bỏ qua xác thực |

## 6. Điểm cần nhớ khi thuyết trình

- Quyền được kiểm soát bằng middleware và controller authorization.
- Không phải mọi user đều thấy mọi action.
- `registrations` là trung tâm của luồng xử lý, nên quyền thường xoay quanh registration.

