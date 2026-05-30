# Checklist Kiểm Tra Thủ Công

Dùng checklist này trước khi demo hoặc nộp bài.

## 1. Môi trường

- `php artisan migrate:fresh --seed` chạy thành công
- `php artisan serve` đang chạy
- `npm run dev` đang chạy nếu muốn xem React
- mở được `http://127.0.0.1:8000/login`

## 2. Đăng nhập và role

- đăng nhập admin được
- đăng nhập lecturer được
- đăng nhập student được
- sai mật khẩu hiển thị lỗi

## 3. Dashboard

- dashboard mở sau khi đăng nhập
- thẻ thống kê hiển thị đúng
- phần analytics React render được
- hiện role breakdown
- hiện department breakdown
- hiện category breakdown
- hiện top lecturers nếu là admin hoặc lecturer

## 4. Topic management

- lecturer hoặc admin tạo topic được
- form topic nhận category, capacity, semester, difficulty, expected outcomes
- danh sách topic tìm kiếm được
- lọc theo status được
- lọc theo category được
- lọc theo difficulty được
- admin chọn lecturer cho topic được
- trang topic detail mở đúng
- trang summary in được

## 5. Registration flow

- student đăng ký topic mở được
- không đăng ký trùng được
- topic đầy capacity thì không đăng ký được
- lecturer duyệt pending registration được
- lecturer từ chối pending registration được

## 6. Submission flow

- student upload PDF được
- student upload DOC/DOCX được
- student thấy report trên dashboard và topic detail
- student xoá report của mình được
- lecturer review report được
- lecturer yêu cầu sửa được
- lecturer chấp nhận report được
- student nộp lại được sau khi bị yêu cầu sửa
- revision number tăng sau khi nộp lại
- review note hiển thị cho student

## 7. Presentation và scoring

- lecturer tạo lịch bảo vệ được
- lecturer sửa lịch bảo vệ được
- lecturer lưu điểm được
- lecturer cập nhật điểm được
- student xem được lịch và điểm

## 8. Activity logs

- mở được activity page
- thấy log tạo topic
- thấy log duyệt registration
- thấy log review report
- thấy log lên lịch bảo vệ
- thấy log chấm điểm

## 9. AI chat

- mở được AI Chat
- load được conversation cũ
- tạo conversation mới được
- quick actions hiển thị
- quick actions gửi prompt được
- gửi message thường được
- rate limit trả lỗi thân thiện khi spam
- chế độ demo cục bộ chạy khi không có `OPENAI_API_KEY`
- cloud AI chạy khi có `OPENAI_API_KEY`

## 10. Admin user management

- admin mở được trang user management
- admin tạo user được
- admin sửa user được
- admin xoá user được
- non-admin bị chặn

## 11. Demo data và notification

- seed tạo nhiều lecturer
- seed tạo nhiều student
- seed tạo topic nhiều category
- seed tạo open/pending/approved/rejected/closed examples
- thông báo email được ghi ra log khi ở chế độ demo

## 12. Kết luận kiểm tra

- test tự động pass
- các luồng chính nhìn thấy được trên UI
- project đủ để demo seminar
