# Học Thuộc Nhanh Laravel Boost

## 1. Boost là gì?

Laravel Boost là lớp hỗ trợ AI cho Laravel.

Mục tiêu:

- giúp AI hiểu đúng project thật
- tránh AI đoán theo kiến thức chung
- dùng ngữ cảnh, guideline, skill và MCP để trả lời sát repo

## 2. Boost dùng file nào?

Các file quan trọng nhất:

- `composer.json` -> có `laravel/boost`
- `boost.json` -> cấu hình Boost
- `AGENTS.md` -> guideline cho agent
- `.github/skills/*` -> skill theo domain
- `.vscode/mcp.json` -> MCP server để AI đọc project
- `app/Support/SeminarAiChat.php` -> logic trả lời AI
- `app/Support/SeminarKnowledgeBase.php` -> cơ sở tri thức nội bộ
- `docs/AI_KNOWLEDGE_BASE.md` -> mô tả dữ liệu AI dùng

## 3. Demo nói gì?

Khi demo, hãy nói theo thứ tự:

1. Boost được cài vào repo như thế nào
2. AI đọc ngữ cảnh từ đâu
3. Vì sao không có key vẫn demo được
4. Demo project chỉ là bối cảnh minh hoạ

### Câu nói mở đầu

> Em dùng một demo project để minh hoạ Laravel Boost, chứ trọng tâm của bài là cách Boost giúp AI hiểu project Laravel thật.

### Câu nói kết luận

> Boost giúp AI hiểu project bằng ngữ cảnh thật thay vì đoán theo kiến thức chung.

## 4. Kịch bản demo cực ngắn

### Bước 1

Mở:

- `composer.json`
- `boost.json`
- `AGENTS.md`

Nói:

> Đây là chỗ cho thấy Boost đã được cài và cấu hình vào repo.

### Bước 2

Mở:

- `app/Support/SeminarAiChat.php`
- `app/Support/SeminarKnowledgeBase.php`

Nói:

> Đây là nơi AI chat lấy ngữ cảnh và trả lời theo local demo mode nếu không có key.

### Bước 3

Mở AI chat trên web và hỏi 2-3 câu:

- `Laravel Boost là gì?`
- `Boost đã được gắn vào project này ở những file nào?`
- `AGENTS.md có vai trò gì?`

### Bước 4

Kết luận:

> Boost giúp AI hiểu project bằng ngữ cảnh thật thay vì đoán theo kiến thức chung.

