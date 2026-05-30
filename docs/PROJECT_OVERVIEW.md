# Tổng Quan Dự Án

Seminar Manager là một ứng dụng Laravel dùng để mô phỏng quy trình seminar trong môi trường học thuật.

## Mục tiêu

Mục tiêu của dự án là cho thấy một hệ thống seminar thực tế có thể được tổ chức như thế nào bằng Laravel:

- quản lý topic
- student đăng ký topic
- lecturer duyệt đăng ký
- upload và review báo cáo
- lên lịch bảo vệ
- chấm điểm
- xem log hoạt động
- dùng AI chat hỗ trợ giải thích dự án

## Vấn đề dự án giải quyết

Quy trình seminar ngoài thực tế thường bị tách ra nhiều nơi:

- topic nằm ở file hoặc nhóm chat
- student đăng ký bằng cách thủ công
- báo cáo gửi rời rạc
- phản hồi của lecturer không được lưu tập trung
- lịch bảo vệ và điểm số khó theo dõi

Dự án này gom toàn bộ quy trình đó vào một hệ thống duy nhất.

## Vai trò người dùng

### Admin

- quản lý user
- xem toàn hệ thống
- theo dõi dashboard

### Lecturer

- tạo và chỉnh sửa topic
- duyệt đăng ký
- review báo cáo
- lên lịch bảo vệ
- chấm điểm

### Student

- xem topic
- đăng ký topic
- upload báo cáo
- xem review
- xem lịch bảo vệ
- xem điểm

## Phạm vi demo

Đây là project demo để:

- hiểu cách Laravel tổ chức code
- hiểu cách thiết kế luồng xử lý
- hiểu quan hệ database
- hiểu cách gắn Laravel Boost vào ngữ cảnh thực tế

Nó không nhằm mục tiêu trở thành một sản phẩm sản xuất hoàn chỉnh.

## Điểm nổi bật

- có phân quyền rõ ràng
- có luồng xử lý học thuật rõ ràng
- có database quan hệ
- có AI chat hỗ trợ
- có dashboard analytics
- có tài liệu để thuyết trình

## Tóm tắt ngắn

Nếu phải nói 1 câu:

> Seminar Manager là một demo Laravel cho quy trình seminar từ tạo topic đến chấm điểm, đồng thời là bối cảnh thực tế để tìm hiểu Laravel Boost.
