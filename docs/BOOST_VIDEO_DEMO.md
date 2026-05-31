# Demo Theo Kiểu Video Laravel Boost

Tài liệu này bổ sung các ý demo theo phong cách video giới thiệu Laravel Boost chính thức.

Mục tiêu là cho bạn có thêm một kịch bản “wow” hơn:

- xem Boost được cài như thế nào
- mở MCP server
- cho AI đọc schema, route, log và docs
- minh hoạ sửa lỗi / tối ưu bằng ngữ cảnh thật

Lưu ý:

- Phần nào làm được trực tiếp trong repo này mình ghi rõ.
- Phần nào cần AI agent/editor thật thì mình cũng ghi rõ để bạn không nhầm.
- Trọng tâm seminar vẫn là **Laravel Boost**, còn `Seminar Manager` chỉ là demo project.

## 1. Cài đặt và thiết lập

Theo kiểu video chính thức, phần đầu tiên là cài Boost và gắn nó vào agent / editor.

### Những file / lệnh cần chỉ

- `composer.json`
- `boost.json`
- `AGENTS.md`
- `.github/skills/*`
- `.vscode/mcp.json`
- `docs/BOOST_TERMINAL_COMMANDS.md`

### Lệnh demo

```bash
composer require laravel/boost --dev
php artisan boost:install
php artisan boost:install --guidelines --skills --mcp --no-interaction
php artisan boost:mcp
```

### Ý nghĩa khi nói

> Boost không chỉ là package, mà là cả một hệ thống guideline, skills và MCP server để AI hiểu đúng project Laravel.

## 2. MCP server làm gì?

MCP là phần cho AI đọc project thật.

### Những thứ Boost có thể đọc qua MCP

- application info
- routes
- database schema
- database queries
- config
- logs
- last errors
- list artisan commands
- docs search
- Tinker
- browser logs
- feedback

### Trong repo của bạn, khi demo hãy mở

- `.vscode/mcp.json`
- `boost.json`
- `AGENTS.md`

### Câu nên nói

> MCP là cầu nối để AI không còn đoán mò, mà có thể nhìn thấy ngữ cảnh thật của project Laravel.

## 3. Demo tương tác với CSDL

Đây là phần rất “video-like” vì cho thấy AI đọc dữ liệu thật của app.

### Có thể demo bằng gì?

- `php artisan tinker`
- `database/schema`
- `route list`
- query thật trong project

### File nên mở

- `app/Models/*`
- `database/migrations/*`
- `app/Http/Controllers/RegistrationController.php`
- `app/Http/Controllers/TopicController.php`

### Ý để nói

> Boost cho AI nhìn vào schema và dữ liệu thật, nên AI có thể nói đúng model, đúng bảng và đúng quan hệ giữa các phần của app.

### Với repo này

Bạn có thể chỉ vào:

- `users`
- `topics`
- `registrations`
- `submissions`
- `presentations`
- `scores`

và nói:

> Đây là database demo, nhưng nó cho Boost đủ ngữ cảnh để hiểu workflow seminar.

## 4. Demo hiệu năng và N+1

Video chính thức có phần nói về hiệu năng và eager loading.

### Với repo của bạn

Bạn có thể minh hoạ bằng:

- `DashboardController.php`
- `TopicController.php`
- các `with(...)` và `whereHas(...)`

### Cách trình bày

> Boost không thay thế tư duy lập trình. Nó giúp AI gợi ý tốt hơn, còn developer vẫn cần review query, relation và eager loading để tránh N+1.

### Nếu muốn làm “wow”

Bạn có thể cho AI:

- soi controller
- xem model relation
- gợi ý chỗ nào nên eager load

Nhưng chỉ nên làm nếu bạn đã test trước.

## 5. Demo gỡ lỗi

Video chính thức thường có phần đọc log, last error, browser logs.

### Trong repo của bạn có thể nói thế nào?

- Boost có MCP tools để đọc logs / last errors
- repo có `ActivityLog` và `ActivityLogger` để minh hoạ logging
- nếu bạn dùng agent/editor thật, AI có thể dựa vào log để đề xuất sửa lỗi

### File nên chỉ

- `app/Http/Controllers/AiChatController.php`
- `app/Support/ActivityLogger.php`
- `docs/BOOST_TERMINAL_COMMANDS.md`

### Câu chốt

> Đây là chỗ Boost khác chatbot thường: nó không chỉ trả lời, mà còn có thể đọc ngữ cảnh lỗi thật của project.

## 6. Demo phản hồi

Video chính thức có nhắc tính năng gửi feedback.

### Nói gì cho đúng?

Trong repo này, bạn có thể nói:

> Boost có cơ chế nhận feedback để cải thiện công cụ. Với seminar, em chỉ minh hoạ rằng Boost là một hệ thống AI tooling có khả năng hỗ trợ phát triển phần mềm thật, chứ không chỉ là một chatbot hỏi đáp.

## 7. Nếu muốn bám sát kiểu video, nên demo theo thứ tự này

1. Chỉ file cài Boost
2. Chỉ MCP server
3. Chỉ knowledge base / AI chat local demo mode
4. Chỉ database schema / models / controller
5. Chỉ logs / activity
6. Kết luận lại rằng Boost giúp AI hiểu project thật

## 8. Những gì nên nói rõ để không lệch

- Demo project không phải trọng tâm chính
- Boost mới là trọng tâm
- AI chat local demo mode là phần minh hoạ
- Khi có editor/agent thật thì mới gọi là demo đầy đủ kiểu Boost tooling

## 9. Câu chốt ngắn

> Laravel Boost là AI tooling cho Laravel, có MCP, guidelines, skills và documentation API để AI hiểu đúng project thật. Demo project chỉ là ngữ cảnh minh hoạ để thấy Boost hoạt động trong thực tế.

