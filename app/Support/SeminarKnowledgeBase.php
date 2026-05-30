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
            '- Seminar Manager là ứng dụng Laravel phục vụ quy trình seminar học thuật trong môi trường đại học.',
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
                'keywords' => ['overview', 'project', 'seminar manager', 'what is this', 'tổng quan', 'dự án', 'giới thiệu'],
                'title' => 'Tổng quan dự án',
                'bullets' => [
                    '- Seminar Manager là ứng dụng Laravel dùng để mô phỏng quy trình seminar trong trường đại học.',
                    '- Ứng dụng giúp quản lý topic, đăng ký, nộp báo cáo, bảo vệ và chấm điểm.',
                    '- React được dùng chủ yếu cho dashboard analytics và AI chat để tăng tính tương tác.',
                    '- Dự án được thiết kế để dễ demo trên lớp nhưng vẫn đủ thật để giải thích quy trình học thuật.',
                ],
                'closing' => 'Nếu muốn, tôi có thể giải thích tiếp về database hoặc phân quyền người dùng.',
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
                    '- AI chat có thể chạy ở chế độ OpenAI nếu cấu hình API key.',
                    '- Nó cũng có chế độ demo cục bộ nên app vẫn hoạt động khi không có kết nối ngoài.',
                    '- Các conversation đã lưu thuộc về từng người dùng nên trợ lý có thể giữ ngữ cảnh.',
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
