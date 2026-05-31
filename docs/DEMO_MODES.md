# Các Kiểu Demo Laravel Boost

Tài liệu này giúp bạn chọn cách demo phù hợp với thời lượng và mức độ “wow” khi thuyết trình.

Trọng tâm vẫn là **Laravel Boost**. `Seminar Manager` chỉ là demo project để minh hoạ.

## 1. Demo 3 phút

Mục tiêu:

- nói nhanh Boost là gì
- chỉ file nào cho thấy Boost đã được cài
- cho AI chat trả lời 1 câu đơn giản

### Cách làm

1. Mở `composer.json`
2. Mở `boost.json`
3. Mở `AGENTS.md`
4. Mở `AI Chat`
5. Hỏi:
   - `Laravel Boost là gì?`
   - `Boost đã được gắn vào project này ở những file nào?`

### Câu nên nói

> Em dùng một demo project để minh hoạ Laravel Boost, chứ trọng tâm của bài là cách Boost giúp AI hiểu project Laravel thật.

### Khi nào dùng

- khi thời lượng ngắn
- khi giảng viên chỉ cần hiểu Boost là gì

## 2. Demo 5 phút

Mục tiêu:

- giải thích Boost
- cho thấy file cấu hình thật
- chỉ vào AI chat local demo mode

### Cách làm

1. Mở `composer.json`
2. Mở `boost.json`
3. Mở `AGENTS.md`
4. Mở `.github/skills/*`
5. Mở `.vscode/mcp.json`
6. Mở `app/Support/SeminarKnowledgeBase.php`
7. Mở `app/Support/SeminarAiChat.php`
8. Mở `AI Chat`
9. Hỏi:
   - `AGENTS.md có vai trò gì?`
   - `.github/skills/* dùng để làm gì?`
   - `Khi không có OpenAI key thì chatbot chạy thế nào?`

### Khi nào dùng

- khi giảng viên muốn nghe thêm một chút về code
- khi bạn muốn vừa nói lý thuyết vừa chỉ file thật

## 3. Demo 10 phút

Mục tiêu:

- cho thấy Boost có file thật trong repo
- cho thấy AI chat hiểu project dựa trên knowledge base
- cho thấy project demo chỉ là ngữ cảnh minh hoạ

### Cách làm

1. Mở `composer.json`
2. Mở `boost.json`
3. Mở `AGENTS.md`
4. Mở `.github/skills/*`
5. Mở `.vscode/mcp.json`
6. Mở `docs/LARAVEL_BOOST_SEMINAR_GUIDE.md`
7. Mở `app/Http/Controllers/AiChatController.php`
8. Mở `app/Support/SeminarAiChat.php`
9. Mở `app/Support/SeminarKnowledgeBase.php`
10. Mở `docs/AI_KNOWLEDGE_BASE.md`
11. Mở `AI Chat` trên web
12. Hỏi 2-3 câu:
    - `Laravel Boost là gì?`
    - `Boost đã được gắn vào project này ở những file nào?`
    - `Demo project này chỉ đóng vai trò gì trong bài seminar?`

### Câu nên chốt

> Boost giúp AI hiểu project bằng ngữ cảnh thật thay vì đoán theo kiến thức chung.

## 4. Demo kiểu “wow”

Mục tiêu:

- tạo cảm giác khác với AI bình thường
- để giảng viên thấy Boost không chỉ là lý thuyết

### Cách làm an toàn

Nếu bạn **chưa có live MCP agent trong editor**, đừng demo cài đặt hay debug live.
Hãy làm “wow” theo cách an toàn:

- so sánh AI không có Boost và có Boost
- mở file cấu hình thật trong repo
- cho AI chat trả lời theo knowledge base nội bộ

### Cách làm nếu có chuẩn bị editor/MCP thật

1. Tạo một lỗi nhỏ trong project
2. Mở log hoặc file liên quan
3. Cho AI agent trong editor đọc lỗi
4. Yêu cầu nó gợi ý sửa

### Lưu ý

- Chỉ làm kiểu này khi bạn đã test trước ở máy mình
- Nếu chưa chắc, đừng demo live debug trên lớp

## 5. Chọn kiểu nào là hợp lý?

- **3 phút**: nếu cần ngắn gọn
- **5 phút**: nếu muốn vừa dễ hiểu vừa có file code
- **10 phút**: nếu muốn trình bày kỹ hơn
- **Wow**: chỉ dùng khi bạn đã test kỹ trước khi lên lớp

## 6. Câu mở đầu và kết luận dùng chung

### Mở đầu

> Em dùng một demo project để minh hoạ Laravel Boost, chứ trọng tâm của bài là cách Boost giúp AI hiểu project Laravel thật.

### Kết luận

> Boost giúp AI hiểu project bằng ngữ cảnh thật thay vì đoán theo kiến thức chung.

