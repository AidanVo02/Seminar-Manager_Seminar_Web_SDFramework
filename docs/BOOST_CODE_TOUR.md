# Hướng Dẫn Đọc Code Về Laravel Boost

File này giúp bạn đọc source đúng trọng tâm để hiểu Laravel Boost.

Mục tiêu của file này là hiểu Boost hoạt động như thế nào trong một demo project thật, không phải học cách xây một hệ thống seminar mới.

## Nên đọc theo thứ tự này

1. `../README.md`
2. `LARAVEL_BOOST_SEMINAR_GUIDE.md`
3. `LECTURER_PRESENTATION.md`
4. `../composer.json`
5. `../boost.json`
6. `../AGENTS.md`
7. `../.github/skills/laravel-best-practices/SKILL.md`
8. `../.github/skills/tailwindcss-development/SKILL.md`
9. `../.vscode/mcp.json`
10. `../app/Support/SeminarKnowledgeBase.php`
11. `../app/Support/SeminarAiChat.php`
12. `../app/Http/Controllers/AiChatController.php`
13. `AI_KNOWLEDGE_BASE.md`

## 1. composer.json

Đây là nơi khai báo Laravel Boost:

```json
"require-dev": {
    "laravel/boost": "^2.4"
}
```

Ý nghĩa:

- Boost là dependency phục vụ phát triển
- không phải business feature cho người dùng cuối

## 2. boost.json

File này cho thấy Boost đã được cấu hình trong repo.

Nội dung hiện tại chủ yếu cho biết:

- bật MCP
- dùng agent nào
- môi trường cloud hay local
- có bật `enforce_tests` hay không

## 3. AGENTS.md

Đây là file hướng dẫn agent chính trong repo khi Boost cài theo Copilot.

Điểm cần nhớ:

- file này chứa guideline do Boost sinh ra
- agent đọc file này trước khi làm việc
- đây là bằng chứng rõ rằng Boost đã được cài vào repo

## 4. `.github/skills/*`

Boost sinh skills theo domain trong thư mục này.

Trong repo hiện tại có:

- `laravel-best-practices`
- `tailwindcss-development`

Ý nghĩa:

- AI có hướng dẫn chuyên biệt theo domain
- không cần nhồi toàn bộ kiến thức vào một prompt dài
- Boost tách phần hướng dẫn theo kỹ năng để agent nạp đúng lúc

## 5. `.vscode/mcp.json`

Đây là nơi khai báo MCP server cho editor/agent.

Trong repo này có:

- `stitch`
- `laravel-boost`

Ý nghĩa:

- agent có thể đọc project qua MCP
- Boost không chỉ là prompt text, nó còn có lớp công cụ thực thi thật

## 6. SeminarKnowledgeBase

File:

- `app/Support/SeminarKnowledgeBase.php`

Vai trò:

- chứa dữ liệu tri thức cục bộ cho AI
- giúp trợ lý trả lời đúng ngữ cảnh của dự án

Bạn nên nhớ:

- đây không phải huấn luyện model
- đây là cơ sở tri thức thủ công để AI bớt đoán mò

## 7. SeminarAiChat

File:

- `app/Support/SeminarAiChat.php`

Vai trò:

- quyết định AI trả lời thế nào
- dùng OpenAI nếu có API key
- dùng chế độ demo cục bộ nếu không có key

Điểm cần hiểu:

- `reply()` là điểm vào chính
- `instructions()` dựng prompt có ngữ cảnh
- `localReply()` là phương án dự phòng

### Code ý tưởng

```php
if (! $apiKey) {
    return [
        'reply' => $this->localReply($user, $message),
        'response_id' => null,
        'model' => 'local-demo',
    ];
}
```

## 8. AiChatController

File:

- `app/Http/Controllers/AiChatController.php`

Vai trò:

- nhận message từ giao diện
- tạo conversation
- lưu message user
- gọi `SeminarAiChat`
- lưu tin nhắn của trợ lý

Nói ngắn gọn:

> Controller lo request, service lo logic trả lời, model lo lưu dữ liệu.

## 9. AI_KNOWLEDGE_BASE.md

File này mô tả:

- trợ lý biết gì
- trợ lý không nên bịa gì
- trợ lý trả lời theo ngữ cảnh nào

Nó rất quan trọng nếu bạn được hỏi:

> AI này lấy kiến thức ở đâu ra?

Câu trả lời đúng là:

- từ ngữ cảnh của dự án
- từ cơ sở tri thức nội bộ
- từ hướng dẫn trong prompt
- từ file agent/skill/MCP do Boost sinh ra
- và khi có API key thì từ OpenAI nữa

## 10. Boost trong seminar này dùng để nói gì?

Điểm chính cần nói:

- Boost giúp AI hiểu project Laravel thật
- Boost giảm việc AI đoán sai route, schema, version
- Boost hợp với một demo project có luồng xử lý rõ ràng

## 11. Câu nói ngắn để thuyết trình

> Laravel Boost là lớp hỗ trợ AI cho Laravel. Trong demo project này, em không huấn luyện model mới mà dùng cơ sở tri thức, AI chat, file agent/skill/MCP và ngữ cảnh của dự án để minh hoạ cách Boost giúp AI hiểu đúng mã nguồn.

## 12. Kết luận

Nếu bạn hiểu 4 file này là đủ:

- `composer.json`
- `boost.json`
- `AGENTS.md`
- `SeminarAiChat.php`

Hai file còn lại chỉ là lớp giao diện và mô tả:

- `AiChatController.php`
- `AI_KNOWLEDGE_BASE.md`
