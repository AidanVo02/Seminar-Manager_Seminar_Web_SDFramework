# Hướng Dẫn Đọc Code Về Laravel Boost

File này giúp bạn đi đúng trọng tâm khi đọc source để hiểu Laravel Boost.

## Nên đọc theo thứ tự này

1. `../README.md`
2. `LARAVEL_BOOST_SEMINAR_GUIDE.md`
3. `LECTURER_PRESENTATION.md`
4. `../composer.json`
5. `../boost.json`
6. `../app/Support/SeminarKnowledgeBase.php`
7. `../app/Support/SeminarAiChat.php`
8. `../app/Http/Controllers/AiChatController.php`
9. `AI_KNOWLEDGE_BASE.md`

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

## 3. SeminarKnowledgeBase

File:

- `app/Support/SeminarKnowledgeBase.php`

Vai trò:

- chứa dữ liệu tri thức cục bộ cho AI
- giúp trợ lý trả lời đúng ngữ cảnh của dự án

Bạn nên nhớ:

- đây không phải huấn luyện model
- đây là cơ sở tri thức thủ công để AI bớt đoán mò

## 4. SeminarAiChat

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

## 5. AiChatController

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

## 6. AI_KNOWLEDGE_BASE.md

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
- và khi có API key thì từ OpenAI nữa

## 7. Boost trong seminar này dùng để nói gì?

Điểm chính cần nói:

- Boost giúp AI hiểu project Laravel thật
- Boost giảm việc AI đoán sai route, schema, version
- Boost hợp với dự án có luồng xử lý rõ ràng như Seminar Manager

## 8. Câu nói ngắn để thuyết trình

> Laravel Boost là lớp hỗ trợ AI cho Laravel. Trong project này, em không huấn luyện model mới mà dùng cơ sở tri thức, AI chat và ngữ cảnh của dự án để minh hoạ cách Boost giúp AI hiểu đúng mã nguồn.

## 9. Kết luận

Nếu bạn hiểu 4 file này là đủ:

- `composer.json`
- `boost.json`
- `SeminarKnowledgeBase.php`
- `SeminarAiChat.php`

Hai file còn lại chỉ là lớp giao diện và mô tả:

- `AiChatController.php`
- `AI_KNOWLEDGE_BASE.md`
