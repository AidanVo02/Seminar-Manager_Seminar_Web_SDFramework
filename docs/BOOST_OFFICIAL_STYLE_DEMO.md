# Demo Theo Hướng Official Laravel Boost

Tài liệu này được bổ sung để demo đi đúng tinh thần của trang chính thức `laravel.com/ai/boost` và repo `laravel/boost`.

Trọng tâm vẫn là **Laravel Boost**.
`Seminar Manager` chỉ là project minh hoạ để Boost có ngữ cảnh thật.

## 1. Laravel Boost thực chất là gì?

Laravel Boost là một **Laravel-focused MCP server** cho phát triển AI-assisted local development.

Nói ngắn:

- Boost chạy ngay trong project Laravel
- Boost cho AI agent đọc ngữ cảnh thật
- Boost cung cấp guideline, skills và docs API
- Boost giúp AI viết code đúng Laravel hơn

## 2. Những điểm official bạn nên nhấn mạnh

Theo tài liệu chính thức, Boost có các phần quan trọng sau:

- **MCP server**
  - cho AI đọc app info, schema, routes, logs, Tinker, config, browser logs, last errors, artisan commands
- **AI guidelines**
  - giúp AI viết code theo chuẩn Laravel
- **Agent skills**
  - bật kỹ năng riêng theo package / domain
- **Documentation API**
  - tìm tài liệu Laravel và ecosystem theo đúng version

## 3. Demo official-style nên nói gì?

### Câu mở đầu

> Laravel Boost là một MCP server cho Laravel, giúp AI agent đọc đúng ngữ cảnh project thật thay vì đoán theo kiến thức chung.

### Câu kết luận

> Boost giúp AI hiểu project bằng ngữ cảnh thật, nên code sinh ra sát Laravel hơn và ít phải sửa tay hơn.

## 4. Cách demo đúng hướng hơn

Nếu muốn bám sát style official, hãy demo theo thứ tự này:

### Bước 1. Chỉ file cài đặt Boost

Mở:

- `composer.json`
- `boost.json`

Nói:

> Đây là bằng chứng Boost đã được đưa vào project bằng Composer và cấu hình riêng cho repo.

### Bước 2. Chỉ phần agent / MCP

Mở:

- `AGENTS.md`
- `.github/skills/*`
- `.vscode/mcp.json`

Nói:

> Đây là nơi Boost đăng ký MCP server và các hướng dẫn cho AI agent.

### Bước 3. Chỉ phần demo thật mà Boost có thể đọc

Mở:

- `routes/web.php`
- `app/Models/*`
- `database/migrations/*`
- `app/Http/Controllers/*`
- `storage/logs/*` nếu có lỗi thật

Nói:

> Boost mạnh nhất khi AI nhìn được route, schema, log và config thật của project.

### Bước 4. Chỉ phần docs API / tri thức

Mở:

- `docs/LARAVEL_BOOST_SEMINAR_GUIDE.md`
- `docs/AI_KNOWLEDGE_BASE.md`

Nói:

> Boost không chỉ đọc source code, mà còn giúp AI tra đúng docs theo version và bám vào tri thức nội bộ của dự án.

## 5. 15+ tools mà Boost nhấn mạnh

Khi nói về MCP, nên nhắc các tool kiểu:

- application info
- routes
- database schema
- database query
- config
- logs
- browser logs
- last errors
- list artisan commands
- search docs
- Tinker
- feedback

Nói:

> Các tool này cho AI nhìn vào trạng thái thật của ứng dụng, thay vì chỉ nhìn text prompt.

## 6. Supported agents

Boost hỗ trợ các agent/editor phổ biến như:

- Cursor
- Claude Code
- GitHub Copilot
- Gemini CLI
- Codex
- Junie

Khi thuyết trình, bạn không cần liệt kê hết, nhưng nên nói:

> Boost được thiết kế để làm việc với các AI coding agent phổ biến, không bị khóa vào một editor duy nhất.

## 7. Cài đặt đúng kiểu official

Các lệnh chuẩn:

```bash
composer require laravel/boost --dev
php artisan boost:install
php artisan boost:update
php artisan boost:mcp
```

### Khi demo, nên nói thêm

> `boost:install` là lệnh sinh file agent / skill / MCP phù hợp với project.
> `boost:update` dùng khi cần đồng bộ lại resources Boost sau khi cập nhật package.

## 8. Demo project của bạn nên được dùng như thế nào?

`Seminar Manager` không phải mục tiêu của bài.
Nó chỉ là:

- một codebase thật
- có route, model, controller, database, log
- đủ ngữ cảnh để minh hoạ Boost

### Vì sao chọn project này hợp lý?

- có nhiều role
- có workflow nhiều bước
- có database thật
- có AI chat local demo mode để minh hoạ kiến thức nội bộ

## 9. Phần nào là “minh hoạ”, phần nào là “Boost thật”?

### Boost thật

- `composer.json`
- `boost.json`
- `AGENTS.md`
- `.github/skills/*`
- `.vscode/mcp.json`
- `php artisan boost:install`
- `php artisan boost:update`
- `php artisan boost:mcp`

### Minh hoạ trong project

- `SeminarKnowledgeBase.php`
- `SeminarAiChat.php`
- `AiChatController.php`
- `README-DEMO.md`
- `LECTURER_PRESENTATION.md`

## 10. Nếu muốn demo giống video official hơn

Bạn nên trình bày theo flow:

1. Cài Boost
2. Mở MCP / agent config
3. Chỉ ra AI có thể đọc schema / route / logs / docs
4. Cho xem project demo có knowledge base
5. Kết luận Boost làm AI “hiểu đúng” project Laravel

## 11. Chốt lại cho đúng trọng tâm

> Laravel Boost là công cụ MCP server + guidelines + skills + docs API giúp AI agent hiểu và hỗ trợ phát triển Laravel tốt hơn. Demo project chỉ là ngữ cảnh minh hoạ để thấy Boost hoạt động trên một codebase thật.

