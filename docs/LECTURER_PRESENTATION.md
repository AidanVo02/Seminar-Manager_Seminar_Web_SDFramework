# Bài Thuyết Trình Laravel Boost https://gamma.app/docs/Giup-AI-hieu-ung-project-that-thay-vi-oan-theo-kien-thuc-chung-rz6i3emmf2jl57a

File này dành cho buổi thuyết trình với giảng viên.

**Trọng tâm là Laravel Boost**. `Seminar Manager` chỉ là project demo để minh hoạ Boost trong một mã nguồn Laravel thật.

## 1. Mở bài

> Laravel Boost là công cụ hỗ trợ AI cho Laravel, giúp AI hiểu đúng project thật thay vì đoán theo kiến thức chung. Em dùng project Seminar Manager để minh hoạ Boost hoạt động như thế nào trong thực tế.

## 2. Boost giải quyết gì?

AI bình thường dễ:

- đoán sai route
- đoán sai schema
- dùng sai API Laravel
- trả lời theo version cũ

Boost giảm lỗi đó bằng cách cung cấp:

- ngữ cảnh của project
- tài liệu đúng version
- MCP tools
- AI guidelines
- agent skills

## 3. Boost nằm ở đâu trong repo?

Các file quan trọng:

- `composer.json`
- `boost.json`
- `app/Support/SeminarAiChat.php`
- `app/Support/SeminarKnowledgeBase.php`
- `app/Http/Controllers/AiChatController.php`
- `docs/AI_KNOWLEDGE_BASE.md`

## 4. Cấu trúc code cần nói

### Routes

```php
Route::middleware('auth')->group(function () {
    Route::get('/ai-chat', [AiChatController::class, 'index'])->name('ai-chat.index');
    Route::post('/ai-chat', [AiChatController::class, 'store'])->name('ai-chat.store');
});
```

Ý nghĩa:

- route là cửa vào của feature
- AI chat được bảo vệ bởi `auth`

### AI chat service

```php
if (! $apiKey) {
    return [
        'reply' => $this->localReply($user, $message),
        'response_id' => null,
        'model' => 'local-demo',
    ];
}
```

Ý nghĩa:

- không có API key thì vẫn demo được
- chế độ demo cục bộ là điểm rất hữu ích khi thuyết trình

### Knowledge base

```php
return implode("\n", [
    'Cơ sở tri thức của dự án:',
    '- Seminar Manager là ứng dụng Laravel phục vụ quy trình seminar học thuật trong môi trường đại học.',
    '- Ứng dụng hỗ trợ ba vai trò chính: admin, lecturer và student.',
]);
```

Ý nghĩa:

- AI không trả lời chung chung
- AI có cơ sở tri thức nội bộ của dự án

## 5. Demo project này dùng để minh hoạ cái gì?

Project giúp minh hoạ 3 điều:

1. Boost cần ngữ cảnh thật để AI trả lời đúng.
2. Cơ sở tri thức giúp AI hiểu project tốt hơn.
3. Laravel app có thể gắn AI vào mà vẫn giữ kiến trúc rõ ràng.

## 6. Kiến trúc nên nói

- Laravel chịu trách nhiệm chính cho luồng xử lý
- Database lưu dữ liệu seminar
- Support classes gom logic dùng chung
- AI chat là nơi thể hiện Boost trong thực tế
- React chỉ dùng ở dashboard/AI chat để tăng tương tác

## 7. Câu hỏi giảng viên hay hỏi

### Boost có phải model AI không?

Không. Boost không phải model AI. Nó là lớp hỗ trợ AI cho Laravel.

### Tại sao cần project demo?

Vì Boost dễ hiểu hơn khi gắn vào một mã nguồn thật có route, model, database và luồng xử lý rõ ràng.

### Nếu không có khóa OpenAI thì sao?

Vẫn chạy được bằng chế độ demo cục bộ.

## 8. Bố cục nói khi thuyết trình

1. Nói Boost là gì
2. Nói Boost giải quyết vấn đề gì
3. Nói Boost gồm những gì
4. Chỉ ra file code liên quan
5. Giải thích demo project minh hoạ Boost ra sao
6. Cho xem AI chat / cơ sở tri thức
7. Kết luận

## 9. Kết luận ngắn

> Laravel Boost giúp AI hiểu đúng project Laravel bằng ngữ cảnh, tài liệu, schema và công cụ hỗ trợ. Seminar Manager chỉ là demo project để minh hoạ cách Boost hoạt động trong thực tế.
