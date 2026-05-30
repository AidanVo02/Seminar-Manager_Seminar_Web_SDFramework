# Database Guide

Tài liệu này giải thích database theo cách dễ học và dễ thuyết trình.

## Ý tưởng chính

Quy trình seminar đi theo chuỗi:

1. Lecturer tạo topic
2. Student đăng ký topic
3. Lecturer duyệt đăng ký
4. Student upload báo cáo
5. Lecturer review báo cáo
6. Lecturer lên lịch bảo vệ
7. Lecturer chấm điểm

Vì vậy, bảng trung tâm của hệ thống là `registrations`.

## Các bảng chính

### `users`

Lưu tài khoản hệ thống:

- admin
- lecturer
- student

Trường đáng nhớ:

- `name`
- `email`
- `role`
- `department`
- `student_code`
- `cohort`

### `topics`

Lưu topic seminar.

Trường đáng nhớ:

- `title`
- `description`
- `category`
- `capacity`
- `semester`
- `difficulty`
- `expected_outcomes`
- `lecturer_id`
- `status`

### `registrations`

Lưu một sinh viên đã đăng ký topic nào.

Trường đáng nhớ:

- `topic_id`
- `student_id`
- `status`

Ràng buộc quan trọng:

- một student không được đăng ký cùng một topic hai lần

### `submissions`

Lưu file báo cáo và trạng thái review.

Trường đáng nhớ:

- `registration_id`
- `original_name`
- `file_path`
- `mime_type`
- `submitted_at`
- `review_status`
- `review_note`
- `reviewed_by`
- `reviewed_at`
- `revision_number`

### `presentations`

Lưu lịch bảo vệ.

Trường đáng nhớ:

- `registration_id`
- `scheduled_at`
- `room`

### `scores`

Lưu điểm cuối cùng.

Trường đáng nhớ:

- `registration_id`
- `score`
- `comment`

### `activity_logs`

Lưu log hoạt động để xem ai đã làm gì.

Trường đáng nhớ:

- `user_id`
- `action`
- `description`
- `subject_type`
- `subject_id`
- `metadata`

### AI chat

Lưu lịch sử chat:

- `ai_chat_conversations`
- `ai_chat_messages`

## Quan hệ dữ liệu

```text
users
  ├── topics (lecturer)
  ├── registrations (student)
  ├── ai_chat_conversations
  └── activity_logs

topics
  └── registrations

registrations
  ├── submission
  ├── presentation
  └── score
```

## Vì sao registrations là bảng quan trọng nhất

Vì nó là điểm nối giữa:

- student
- topic
- submission
- presentation
- score

Nếu hiểu được `registrations`, bạn gần như hiểu được toàn bộ luồng xử lý.

## Dữ liệu demo

Seeder tạo sẵn:

- nhiều lecturer
- nhiều student
- topic open/closed
- registration pending/approved/rejected
- submission đã review và chưa review
- presentation
- score

Nhờ vậy chạy demo lên là có dữ liệu ngay.

## Ghi nhớ nhanh

> `users` là người dùng, `topics` là đề tài, `registrations` là trung tâm của luồng xử lý, `submissions` là báo cáo, `presentations` là lịch bảo vệ, `scores` là kết quả cuối cùng.
