<?php

namespace App\Support;

use App\Models\Presentation;
use App\Models\Registration;
use App\Models\Submission;
use App\Models\Topic;
use App\Models\User;

class SeminarAiChat
{
    // reply() là điểm vào duy nhất cho phản hồi của trợ lý trong demo này.
    public function reply(User $user, string $message, ?string $previousResponseId = null): array
    {
        return [
            'reply' => $this->localReply($user, $message),
            'response_id' => null,
            'model' => 'local-demo',
        ];
    }

    // instructions() dựng prompt kèm ngữ cảnh thực của dự án.
    protected function instructions(User $user): string
    {
        $recentTopics = Topic::query()
            ->latest()
            ->take(5)
            ->pluck('title')
            ->implode(', ');

        $openTopics = Topic::query()->where('status', 'open')->count();
        $pendingRegistrations = Registration::query()->where('status', 'pending')->count();
        $roleContext = match ($user->role) {
            'student' => $this->studentContext($user),
            'lecturer' => $this->lecturerContext($user),
            'admin' => $this->adminContext(),
            default => 'Không có ngữ cảnh seminar bổ sung nào dành riêng cho vai trò này.',
        };

        return implode("\n", [
            'Bạn là SeminarBoost AI, trợ lý tích hợp của ứng dụng Laravel Seminar Manager.',
            'Nhiệm vụ của bạn là giúp người dùng hiểu topic seminar, luồng đăng ký, lịch bảo vệ, chấm điểm và cách sử dụng hệ thống này.',
            'Hãy trả lời ngắn gọn, thực tế và dễ theo dõi đối với người dùng trong môi trường đại học.',
            'Ưu tiên Markdown gọn với tiêu đề ngắn hoặc gạch đầu dòng khi điều đó làm câu trả lời rõ ràng hơn.',
            'Nếu người dùng hỏi về cách triển khai dự án, hãy trả lời theo Laravel, Blade, React analytics, các bảng cơ sở dữ liệu và workflow theo vai trò.',
            'Không được bịa ra bản ghi riêng tư và không được nói rằng bạn đã tự thay đổi dữ liệu. Bạn là trợ lý chat, không phải tác nhân tự động thực thi nghiệp vụ.',
            SeminarKnowledgeBase::contextBlock(),
            "Vai trò hiện tại của user: {$user->role}.",
            "Tên hiện tại của user: {$user->name}.",
            "Số topic seminar đang mở trong hệ thống: {$openTopics}.",
            "Số registration đang chờ trong hệ thống: {$pendingRegistrations}.",
            'Các topic gần đây trong hệ thống: '.($recentTopics !== '' ? $recentTopics : 'Hiện chưa có topic nào.'),
            $roleContext,
        ]);
    }

    // Ngữ cảnh theo vai trò giúp trợ lý trả lời sát nhu cầu hơn.
    protected function studentContext(User $user): string
    {
        $registrations = Registration::query()
            ->with(['topic', 'presentation', 'score', 'submission'])
            ->where('student_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function (Registration $registration) {
                $presentation = $registration->presentation
                    ? $registration->presentation->scheduled_at->format('d/m/Y H:i').' tại '.$registration->presentation->room
                    : 'chưa xếp lịch';

                $score = $registration->score
                    ? number_format((float) $registration->score->score, 2).'/10'
                    : 'chưa chấm điểm';

                $submission = $registration->submission
                    ? "{$registration->submission->review_status}, revision {$registration->submission->revision_number}"
                    : 'chưa upload báo cáo';

                return "{$registration->topic->title} ({$registration->status}, báo cáo: {$submission}, bảo vệ: {$presentation}, điểm: {$score})";
            })
            ->implode('; ');

        return 'Ngữ cảnh của student: '.($registrations !== '' ? $registrations : 'Student hiện chưa có đăng ký seminar nào.');
    }

    // Ngữ cảnh giảng viên tóm tắt khối lượng hướng dẫn và review.
    protected function lecturerContext(User $user): string
    {
        $topicTitles = Topic::query()
            ->where('lecturer_id', $user->id)
            ->latest()
            ->take(5)
            ->pluck('title')
            ->implode(', ');

        $pendingReviews = Registration::query()
            ->where('status', 'pending')
            ->whereHas('topic', fn ($query) => $query->where('lecturer_id', $user->id))
            ->count();

        $submissionReviews = Submission::query()
            ->whereHas('registration.topic', fn ($query) => $query->where('lecturer_id', $user->id))
            ->whereIn('review_status', ['submitted', 'changes_requested'])
            ->count();

        return 'Ngữ cảnh của lecturer: '
            .'Các topic đang phụ trách: '.($topicTitles !== '' ? $topicTitles : 'chưa có').'. '
            ."Số đăng ký đang chờ duyệt: {$pendingReviews}. "
            ."Số submission cần lecturer xử lý: {$submissionReviews}.";
    }

    // Ngữ cảnh admin bao quát toàn hệ thống và tóm tắt tình trạng luồng xử lý.
    protected function adminContext(): string
    {
        $upcomingPresentations = Presentation::query()
            ->where('scheduled_at', '>=', now())
            ->count();
        $acceptedReports = Submission::query()->where('review_status', 'accepted')->count();
        $changesRequested = Submission::query()->where('review_status', 'changes_requested')->count();

        return "Ngữ cảnh của admin: số buổi bảo vệ sắp tới trong hệ thống: {$upcomingPresentations}. Số báo cáo đã chấp nhận: {$acceptedReports}. Số báo cáo cần chỉnh sửa: {$changesRequested}.";
    }

    // Trích phần text phản hồi tốt nhất từ payload của OpenAI.
    protected function extractReplyText(array $data): string
    {
        $outputText = trim((string) data_get($data, 'output_text', ''));

        if ($outputText !== '') {
            return $outputText;
        }

        $segments = [];

        foreach ((array) data_get($data, 'output', []) as $item) {
            foreach ((array) data_get($item, 'content', []) as $content) {
                $text = data_get($content, 'text');

                if (is_string($text) && trim($text) !== '') {
                    $segments[] = trim($text);
                }
            }
        }

        $reply = trim(implode("\n\n", $segments));

        return $reply !== '' ? $reply : 'Trợ lý AI trả về phản hồi rỗng.';
    }

    // localReply() là chế độ chạy mặc định cho seminar demo.
    protected function localReply(User $user, string $message): string
    {
        $knowledge = SeminarKnowledgeBase::answerFor($message, $user->role);

        if ($knowledge) {
            return $this->localMarkdown(
                '## '.$knowledge['title'],
                $knowledge['bullets'],
                $knowledge['closing']
            );
        }

        return $this->localMarkdown(
            '## Seminar Manager',
            [
                '- Đây là trợ lý demo cục bộ.',
                '- Nó có thể giải thích cấu trúc dự án, workflow, cơ sở dữ liệu và các vai trò.',
                '- Nó dùng một bộ tri thức được chọn lọc để câu trả lời bám sát dự án thật.',
                '- Nó không phụ thuộc vào OpenAI key để chạy demo seminar.',
            ],
            'Hãy thử hỏi về Boost, AGENTS.md, skills, MCP, knowledge base, hoặc vì sao demo project này minh hoạ Laravel Boost.'
        );
    }

    // localMarkdown giúp câu trả lời demo dễ đọc trên giao diện.
    protected function localMarkdown(string $title, array $bullets, string $closing): string
    {
        $lines = [$title];

        foreach ($bullets as $bullet) {
            $lines[] = $bullet;
        }

        $lines[] = '';
        $lines[] = $closing;

        return implode("\n", $lines);
    }
}
