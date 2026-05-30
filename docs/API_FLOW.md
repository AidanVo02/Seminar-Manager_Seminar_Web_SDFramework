# Luồng Route Và Dữ Liệu

Tài liệu này trả lời câu hỏi: route nào làm gì, và chạm vào bảng nào.

## 1. Đây là app web, không phải REST API riêng

Project này chủ yếu là Laravel web app render bằng Blade.

React chỉ dùng ở:

- dashboard analytics
- AI chat

Nghĩa là phần lớn luồng đi qua `routes/web.php` và controller Laravel.

## 2. Luồng đăng nhập

### Route

- `GET /login`
- `POST /login`

### Controller

- `AuthController`

### Bảng liên quan

- `users`
- `sessions`

## 3. Dashboard

### Route

- `GET /dashboard`

### Controller

- `DashboardController`

### Đọc dữ liệu từ

- `users`
- `topics`
- `registrations`
- `submissions`
- `presentations`
- `scores`
- `activity_logs`

### Ghi chú

- route này trả về Blade view
- React chỉ mount vào phần analytics

## 4. Topics

### Routes

- `GET /topics`
- `GET /topics/{topic}`
- `GET /topics/create`
- `POST /topics`
- `GET /topics/{topic}/edit`
- `PUT /topics/{topic}`
- `DELETE /topics/{topic}`

### Controller

- `TopicController`

### Bảng liên quan

- `topics`
- `users`
- `registrations`
- `activity_logs`

### Chức năng

- xem danh sách topic
- lọc topic
- tạo topic
- sửa topic
- xoá topic
- xem topic detail

## 5. Đăng ký topic

### Routes

- `POST /topics/{topic}/register`
- `PATCH /registrations/{registration}/status`

### Controller

- `RegistrationController`

### Bảng liên quan

- `registrations`
- `topics`
- `users`
- `activity_logs`

### Ý nghĩa

- student tạo registration
- lecturer/admin đổi trạng thái `pending`, `approved`, `rejected`

## 6. Upload và review báo cáo

### Routes

- `POST /registrations/{registration}/submission`
- `DELETE /submissions/{submission}`
- `GET /submissions/{submission}/download`
- `PATCH /submissions/{submission}/review`

### Controller

- `SubmissionController`

### Bảng liên quan

- `submissions`
- `registrations`
- `users`
- `activity_logs`

## 7. Lên lịch bảo vệ

### Routes

- `GET /registrations/{registration}/presentation/create`
- `POST /registrations/{registration}/presentation`
- `GET /presentations/{presentation}/edit`
- `PUT /presentations/{presentation}`

### Controller

- `PresentationController`

### Bảng liên quan

- `presentations`
- `registrations`
- `activity_logs`

## 8. Chấm điểm

### Routes

- `POST /registrations/{registration}/score`
- `PUT /scores/{score}`

### Controller

- `ScoreController`

### Bảng liên quan

- `scores`
- `registrations`
- `activity_logs`

## 9. Activity logs

### Route

- `GET /activity`

### Controller

- `ActivityLogController`

### Bảng liên quan

- `activity_logs`
- `users`

## 10. AI chat

### Routes

- `GET /ai-chat`
- `POST /ai-chat`
- `POST /ai-chat/conversations`
- `GET /ai-chat/conversations/{conversation}`

### Controller

- `AiChatController`

### Bảng liên quan

- `ai_chat_conversations`
- `ai_chat_messages`
- `users`
- `topics`
- `registrations`
- `presentations`
- `scores`
- `activity_logs`

## 11. Tóm tắt để nhớ

| Nhóm route | Controller | Bảng chính |
|---|---|---|
| Login | `AuthController` | `users`, `sessions` |
| Dashboard | `DashboardController` | nhiều bảng |
| Topics | `TopicController` | `topics` |
| Registrations | `RegistrationController` | `registrations` |
| Submissions | `SubmissionController` | `submissions` |
| Presentations | `PresentationController` | `presentations` |
| Scores | `ScoreController` | `scores` |
| Activity | `ActivityLogController` | `activity_logs` |
| AI chat | `AiChatController` | `ai_chat_*` |

