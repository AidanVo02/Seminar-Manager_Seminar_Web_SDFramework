<?php

namespace App\Support;

use Illuminate\Support\Str;

class SeminarKnowledgeBase
{
    // contextBlock() được chèn vào prompt AI như một bộ thông tin dự án ổn định.
    public static function contextBlock(): string
    {
        return implode("\n", [
            'Cơ sở tri thức của dự án:',
            '- Demo project là ứng dụng Laravel phục vụ quy trình seminar học thuật trong môi trường đại học.',
            '- Frontend dùng mô hình lai giữa Blade và React, trong đó React chủ yếu dùng cho dashboard analytics và AI chat.',
            '- Ứng dụng hỗ trợ ba vai trò chính: admin, lecturer và student.',
            '- Thực thể trung tâm là `registrations`, dùng để nối sinh viên với topic và kéo theo các phần submission, presentation và score.',
            '- Hệ thống bao gồm quản lý topic, duyệt đăng ký, review báo cáo, lập lịch bảo vệ, chấm điểm, nhật ký hoạt động và AI chat.',
            '- Chatbot phải trả lời theo hướng thực tế, không được bịa ra bản ghi không có trong database.',
        ]);
    }

    // answerFor() ánh xạ từ khóa sang câu trả lời ngắn, dễ trình bày trên lớp.
    public static function answerFor(string $message, string $role): ?array
    {
        $lower = Str::of($message)->lower();

        $topics = [
            [
                'keywords' => ['laravel boost', 'boost là gì', 'boost gi', 'laravel boost là gì', 'what is laravel boost', 'boost help', 'boost giúp gì', 'boost dùng để làm gì'],
                'title' => 'Laravel Boost là gì?',
                'bullets' => [
                    '- Laravel Boost là lớp hỗ trợ AI dành cho Laravel, không phải feature cho user cuối.',
                    '- Nó giúp AI hiểu đúng repo thật thông qua guideline, skill, MCP và tài liệu của project.',
                    '- Trong demo này, Boost dùng một project Laravel thật để minh hoạ cách AI đọc ngữ cảnh từ code.',
                    '- Mục tiêu của Boost là làm cho AI trả lời sát với cấu trúc và dữ liệu của dự án hơn.',
                    '- Các file chứng minh Boost đã được cài gồm `AGENTS.md`, `boost.json`, `.github/skills/*` và `.vscode/mcp.json`.',
                ],
                'closing' => 'Nếu muốn, tôi có thể chỉ ra ngay các file trong repo chứng minh Boost đã được cài đúng.',
            ],
            [
                'keywords' => ['boost đã được gắn', 'file nào cho thấy boost', 'boost cài vào repo', 'đã cài boost', 'boost install', 'composer.json', 'boost.json', 'agents.md', '.github/skills', '.vscode/mcp.json'],
                'title' => 'Các file chứng minh Boost đã được cài',
                'bullets' => [
                    '- `composer.json` khai báo package `laravel/boost`.',
                    '- `boost.json` giữ cấu hình Boost cho repo.',
                    '- `AGENTS.md` là guideline chính cho agent.',
                    '- `.github/skills/*` chứa các kỹ năng mà Boost có thể dùng.',
                    '- `.vscode/mcp.json` khai báo MCP để AI đọc ngữ cảnh project.',
                ],
                'closing' => 'Đây là nhóm file quan trọng nhất nếu bạn muốn chứng minh Boost đang có mặt trong repo.',
            ],
            [
                'keywords' => ['mcp', 'mcp server', 'vscode/mcp.json', 'agent', 'skills', 'guideline', 'agets', 'agests', 'copilot', 'ai đọc project', 'đọc project như thế nào'],
                'title' => 'MCP, skills và guideline',
                'bullets' => [
                    '- MCP giúp AI kết nối và đọc ngữ cảnh từ project thật.',
                    '- `AGENTS.md` mô tả cách AI nên làm việc trong repo này.',
                    '- `.github/skills/*` là các kỹ năng theo domain mà AI có thể tham chiếu.',
                    '- Nhờ vậy AI không chỉ đoán bừa mà có thêm bối cảnh từ chính codebase.',
                ],
                'closing' => 'Nếu cần, tôi có thể giải thích riêng vai trò của từng file này bằng tiếng dễ hiểu hơn.',
            ],
            [
                'keywords' => ['local demo mode', 'demo mode', 'không cần openai', 'no openai', 'không phụ thuộc key', 'key', 'api key', 'openai key', 'chatbot không cần key'],
                'title' => 'Chế độ demo cục bộ',
                'bullets' => [
                    '- Chatbot ở dự án này có thể chạy local demo mode nên không bắt buộc phải có OpenAI key.',
                    '- Điều này giúp buổi seminar ổn định, không phụ thuộc billing hoặc mạng.',
                    '- Khi demo, đây là chế độ nên dùng vì ít rủi ro hơn dùng cloud thật.',
                ],
                'closing' => 'Nếu muốn, tôi có thể chỉ luôn file nào đang quyết định chatbot chạy local demo mode.',
            ],
            [
                'keywords' => ['overview', 'project', 'seminar manager', 'what is this', 'tổng quan', 'dự án', 'giới thiệu'],
                'title' => 'Tổng quan demo project',
                'bullets' => [
                    '- Demo project là ứng dụng Laravel dùng để mô phỏng quy trình seminar trong trường đại học.',
                    '- Nó là bối cảnh minh hoạ để Laravel Boost có dữ liệu và code thật để đọc.',
                    '- Ứng dụng giúp quản lý topic, đăng ký, nộp báo cáo, bảo vệ và chấm điểm.',
                    '- React được dùng chủ yếu cho dashboard analytics và AI chat để tăng tính tương tác.',
                ],
                'closing' => 'Nếu muốn, tôi có thể giải thích tiếp vì sao demo project này hữu ích cho việc học Boost.',
            ],
            [
                'keywords' => ['database', 'schema', 'table', 'erd', 'cơ sở dữ liệu', 'bảng', 'sơ đồ'],
                'title' => 'Kiến thức cơ sở dữ liệu',
                'bullets' => [
                    '- `users` lưu admin, lecturer và student.',
                    '- `topics` lưu đề tài seminar, gồm capacity, semester, category và difficulty.',
                    '- `registrations` là bảng trung tâm nối sinh viên với topic.',
                    '- `submissions`, `presentations`, `scores` và `activity_logs` đều bám theo luồng registration.',
                ],
                'closing' => 'Tôi cũng có thể giải thích quan hệ giữa các bảng theo từng bước thật ngắn gọn.',
            ],
            [
                'keywords' => ['role', 'admin', 'lecturer', 'student', 'permissions', 'quyền', 'phân quyền'],
                'title' => 'Phân quyền người dùng',
                'bullets' => [
                    '- Admin quản lý user, topic và có quyền nhìn toàn hệ thống.',
                    '- Lecturer quản lý topic seminar, duyệt đăng ký, review báo cáo, lập lịch bảo vệ và công bố điểm.',
                    '- Student đăng ký topic, upload báo cáo, theo dõi phản hồi và xem kết quả.',
                ],
                'closing' => 'Phân quyền được giữ đơn giản để bài seminar dễ hiểu và dễ demo.',
            ],
            [
                'keywords' => ['registration', 'register', 'topic signup', 'đăng ký'],
                'title' => 'Luồng đăng ký',
                'bullets' => [
                    '- Student mở trang chi tiết của topic.',
                    '- Student bấm đăng ký nếu topic đang mở và còn chỗ.',
                    '- Lecturer xem yêu cầu và duyệt hoặc từ chối.',
                    '- Khi đã duyệt, registration trở thành một phần của workflow seminar.',
                ],
                'closing' => 'Đây là luồng chính mà demo đi từ đầu đến cuối.',
            ],
            [
                'keywords' => ['report', 'submission', 'review', 'resubmit', 'revision', 'báo cáo', 'nộp lại', 'phản hồi'],
                'title' => 'Luồng review báo cáo',
                'bullets' => [
                    '- Student upload báo cáo PDF, DOC hoặc DOCX.',
                    '- Lecturer có thể chấp nhận submission hoặc yêu cầu chỉnh sửa kèm ghi chú.',
                    '- Nếu bị yêu cầu chỉnh sửa, student có thể nộp lại bản mới.',
                    '- Mỗi revision đều được theo dõi để lịch sử rõ ràng.',
                ],
                'closing' => 'Nhờ vậy project có vòng phản hồi học thuật giống quy trình thật.',
            ],
            [
                'keywords' => ['score', 'grading', 'grade', 'marks', 'điểm', 'chấm điểm'],
                'title' => 'Luồng chấm điểm',
                'bullets' => [
                    '- Lecturer nhập điểm từ 0 đến 10.',
                    '- Có thể ghi thêm nhận xét kèm điểm.',
                    '- Kết quả hiển thị lại cho student ở dashboard và topic detail.',
                ],
                'closing' => 'Điểm được gắn với registration nên luôn đi cùng workflow của sinh viên.',
            ],
            [
                'keywords' => ['dashboard', 'analytics', 'chart', 'stats', 'bảng điều khiển', 'biểu đồ', 'thống kê'],
                'title' => 'Phân tích dashboard',
                'bullets' => [
                    '- Laravel render khung app và dữ liệu chính.',
                    '- React render panel analytics tương tác.',
                    '- Dashboard có thể hiển thị trạng thái đăng ký, phân bố vai trò, phân bố khoa/phòng và phân bố category đề tài.',
                ],
                'closing' => 'Đây là phần phù hợp nhất để minh họa kiến trúc Laravel + React lai.',
            ],
            [
                'keywords' => ['ai chat', 'chatbot', 'assistant', 'openai', 'gpt', 'trợ lý', 'hỏi đáp'],
                'title' => 'Trợ lý AI',
                'bullets' => [
                    '- AI chat chạy ở chế độ demo cục bộ nên app vẫn hoạt động khi không có kết nối ngoài.',
                    '- Không cần API key để demo seminar.',
                    '- Các conversation đã lưu thuộc về từng người dùng nên trợ lý có thể giữ ngữ cảnh.',
                    '- Trong demo, mục tiêu của AI chat là minh hoạ Boost đọc ngữ cảnh từ project thật.',
                ],
                'closing' => 'Điều này giúp demo ổn định ngay cả khi thuyết trình trong lớp hoặc test offline.',
            ],
            [
                'keywords' => ['deployment', 'run', 'install', 'setup', 'chạy', 'cài đặt', 'triển khai'],
                'title' => 'Chạy và triển khai',
                'bullets' => [
                    '- Cài Composer dependencies và NPM dependencies.',
                    '- Chạy migration và seed dữ liệu demo.',
                    '- Khởi động Laravel và Vite cho giao diện lai.',
                ],
                'closing' => 'Tôi cũng có thể đưa checklist demo nhanh nếu bạn cần.',
            ],
            [
                'keywords' => ['topic management', 'create topic', 'new seminar', 'quản lý topic', 'đề tài', 'seminar topic'],
                'title' => 'Quản lý topic seminar',
                'bullets' => [
                    '- Lecturer và admin có thể tạo, sửa, xoá topic trong hệ thống.',
                    '- Topic có các field như title, description, category, capacity, semester và difficulty.',
                    '- Đây là phần minh hoạ rõ nhất cho route, controller, model và validation trong Laravel.',
                ],
                'closing' => 'Nếu muốn, tôi có thể giải thích sâu hơn về route và controller của topic.',
            ],
            [
                'keywords' => ['presentation', 'schedule', 'lịch bảo vệ', 'bảo vệ', 'presentation schedule', 'create presentation'],
                'title' => 'Lập lịch bảo vệ',
                'bullets' => [
                    '- Lecturer và admin có thể xếp lịch bảo vệ sau khi registration được duyệt.',
                    '- Dữ liệu lịch bảo vệ gắn với registration để theo dõi toàn bộ workflow.',
                    '- Đây là ví dụ tốt cho quan hệ giữa các bảng và xử lý dữ liệu theo luồng.',
                ],
                'closing' => 'Tôi cũng có thể mô tả chính xác controller và route cho phần này.',
            ],
            [
                'keywords' => ['user management', 'manage users', 'quản lý user', 'admin user', 'người dùng', 'vai trò user'],
                'title' => 'Quản lý người dùng',
                'bullets' => [
                    '- Admin có thể tạo và chỉnh sửa user trong hệ thống.',
                    '- User gồm admin, lecturer và student.',
                    '- Phần này minh hoạ rõ cơ chế phân quyền trong ứng dụng Laravel.',
                ],
                'closing' => 'Nếu muốn, tôi có thể nói tiếp phần admin kiểm soát hệ thống như thế nào.',
            ],
            [
                'keywords' => ['activity log', 'activity logs', 'nhật ký hoạt động', 'audit', 'log'],
                'title' => 'Nhật ký hoạt động',
                'bullets' => [
                    '- Hệ thống ghi lại những hành động quan trọng như tạo topic, duyệt đăng ký, review báo cáo và chấm điểm.',
                    '- Activity log giúp giảng viên và admin theo dõi lịch sử thao tác.',
                    '- Đây là phần minh hoạ tốt cho auditing trong ứng dụng Laravel.',
                ],
                'closing' => 'Tôi có thể tóm tắt route hoặc controller của activity log nếu bạn cần.',
            ],
            [
                'keywords' => ['summary', 'export', 'print', 'pdf', 'tóm tắt topic', 'in / lưu pdf', 'xuất báo cáo'],
                'title' => 'Xuất tóm tắt topic',
                'bullets' => [
                    '- Trang in tóm tắt topic được thiết kế để preview hoặc lưu PDF.',
                    '- Đây là ví dụ cho export-friendly HTML trong Laravel.',
                    '- Chức năng này giúp minh hoạ cách dữ liệu được gom lại để trình bày.',
                ],
                'closing' => 'Nếu muốn, tôi có thể mô tả cách file view này lấy dữ liệu từ controller.',
            ],
        ];

        foreach ($topics as $topic) {
            foreach ($topic['keywords'] as $keyword) {
                if ($lower->contains($keyword)) {
                    return [
                        'title' => $topic['title'],
                        'bullets' => $topic['bullets'],
                        'closing' => $topic['closing'],
                    ];
                }
            }
        }

        $roleTopic = match ($role) {
            'student' => [
                'title' => 'Hướng dẫn cho student',
                'bullets' => [
                    '- Bạn có thể hỏi về đăng ký, báo cáo, phản hồi, lịch bảo vệ và điểm.',
                    '- Trợ lý có thể tóm tắt workflow hiện tại của bạn bằng ngôn ngữ đơn giản.',
                ],
                'closing' => 'Hãy thử hỏi: "Sau khi đăng ký topic thì tôi cần làm gì tiếp theo?"',
            ],
            'lecturer' => [
                'title' => 'Hướng dẫn cho lecturer',
                'bullets' => [
                    '- Bạn có thể hỏi về duyệt đăng ký, review báo cáo, lên lịch và chấm điểm.',
                    '- Trợ lý có thể giải thích cách hành động của lecturer ảnh hưởng đến workflow.',
                ],
                'closing' => 'Hãy thử hỏi: "Cho tôi xem workflow của lecturer trong seminar."',
            ],
            'admin' => [
                'title' => 'Hướng dẫn cho admin',
                'bullets' => [
                    '- Bạn có thể hỏi về user, analytics, quản lý topic và tổng quan hệ thống.',
                    '- Trợ lý có thể giải thích cách vai trò admin hỗ trợ toàn bộ hệ thống.',
                ],
                'closing' => 'Hãy thử hỏi: "Tóm tắt cấu trúc toàn bộ dự án cho tôi."',
            ],
            default => null,
        };

        return $roleTopic;
    }
}
