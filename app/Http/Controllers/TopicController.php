<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use App\Models\ActivityLog;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopicController extends Controller
{
    // Danh sách topic là màn hình duyệt chính của luồng seminar.
    public function index(Request $request): View
    {
        $user = $request->user();
        // Lọc dữ liệu được validate trước để query rõ ràng và an toàn.
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:open,closed'],
            'lecturer_id' => ['nullable', 'integer', 'exists:users,id'],
            'category' => ['nullable', 'string', 'max:100'],
            'difficulty' => ['nullable', 'in:beginner,intermediate,advanced'],
        ]);

        // Query index nạp đủ quan hệ mà UI cần.
        $topics = Topic::with([
                'lecturer',
                'registrations.student',
                'registrations.presentation',
                'registrations.score',
                'registrations.submission',
            ])
            ->withCount('registrations')
            ->when($user->isLecturer(), fn ($query) => $query->where('lecturer_id', $user->id))
            ->when($filters['q'] ?? null, function ($query, $term) {
                $query->where(function ($inner) use ($term) {
                    $inner->where('title', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when(($filters['lecturer_id'] ?? null) && ! $user->isLecturer(), fn ($query, $lecturerId) => $query->where('lecturer_id', $lecturerId))
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('category', $category))
            ->when($filters['difficulty'] ?? null, fn ($query, $difficulty) => $query->where('difficulty', $difficulty))
            ->latest()
            ->get();

        // Danh sách giảng viên phục vụ dropdown cho admin và bộ lọc theo giảng viên.
        $lecturers = User::query()
            ->where('role', 'lecturer')
            ->orderBy('name')
            ->get(['id', 'name']);

        // Danh mục được lấy động để bộ lọc khớp với dữ liệu seed.
        $categories = Topic::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('topics.index', compact('topics', 'filters', 'lecturers', 'categories'));
    }

    // Form tạo mới chỉ cần danh sách giảng viên, không cần toàn bộ dataset topic.
    public function create(Request $request): View
    {
        return view('topics.create', [
            'lecturers' => $this->lecturersForForm($request->user()),
        ]);
    }

    // Store tạo bản ghi topic seminar thực sự.
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['lecturer_id'] = $this->resolveLecturerId($request, $data['lecturer_id'] ?? null);

        $topic = Topic::create($data);
        // Log thao tác quan trọng giúp giải thích luồng xử lý khi thuyết trình.
        ActivityLogger::log(
            $request->user(),
            'topic.created',
            "{$request->user()->name} created the topic {$topic->title}.",
            $topic,
            [
                'topic_id' => $topic->id,
                'lecturer_id' => $topic->lecturer_id,
            ]
        );

        return redirect()->route('topics.index')->with('status', 'Topic created successfully.');
    }

    // Trang chi tiết nạp toàn bộ trạng thái lồng nhau của một topic.
    public function show(Topic $topic): View
    {
        $topic->load([
            'lecturer',
            'registrations.student',
            'registrations.presentation',
            'registrations.score',
            'registrations.submission.reviewer',
        ]);

        $activities = ActivityLog::query()
            ->with('user')
            ->where('metadata->topic_id', $topic->id)
            ->latest()
            ->take(10)
            ->get();

        return view('topics.show', compact('topic', 'activities'));
    }

    // Chỉnh sửa chỉ dành cho giảng viên sở hữu hoặc admin.
    public function edit(Request $request, Topic $topic): View
    {
        $this->authorizeTopicAccess($request->user(), $topic);

        return view('topics.edit', [
            'topic' => $topic,
            'lecturers' => $this->lecturersForForm($request->user()),
        ]);
    }

    // Update dùng cùng quy tắc truy cập với edit.
    public function update(Request $request, Topic $topic): RedirectResponse
    {
        $this->authorizeTopicAccess($request->user(), $topic);

        $data = $this->validatedData($request);
        $data['lecturer_id'] = $this->resolveLecturerId($request, $data['lecturer_id'] ?? $topic->lecturer_id);

        $topic->update($data);
        ActivityLogger::log(
            $request->user(),
            'topic.updated',
            "{$request->user()->name} updated the topic {$topic->title}.",
            $topic,
            [
                'topic_id' => $topic->id,
                'lecturer_id' => $topic->lecturer_id,
            ]
        );

        return redirect()->route('topics.show', $topic)->with('status', 'Topic updated successfully.');
    }

    // Xóa chỉ được phép theo quyền quản trị hoặc quyền sở hữu.
    public function destroy(Request $request, Topic $topic): RedirectResponse
    {
        $this->authorizeTopicAccess($request->user(), $topic);

        $title = $topic->title;
        $topic->delete();
        ActivityLogger::log(
            $request->user(),
            'topic.deleted',
            "{$request->user()->name} deleted the topic {$title}.",
            null,
            [
                'topic_id' => $topic->id,
                'lecturer_id' => $topic->lecturer_id,
                'topic_title' => $title,
            ]
        );

        return redirect()->route('topics.index')->with('status', 'Topic deleted successfully.');
    }

    // Admin truy cập được mọi topic; giảng viên chỉ truy cập topic của mình.
    protected function authorizeTopicAccess(User $user, Topic $topic): void
    {
        if ($user->isAdmin()) {
            return;
        }

        abort_unless($user->isLecturer() && $topic->lecturer_id === $user->id, 403);
    }

    // Gom validation ở một chỗ để create/update dùng cùng bộ luật.
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'category' => ['required', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'semester' => ['nullable', 'string', 'max:100'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'expected_outcomes' => ['nullable', 'string', 'max:3000'],
            'status' => ['required', 'in:open,closed'],
            'lecturer_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);
    }

    // Admin có thể chọn giảng viên; giảng viên bị ràng buộc vào chính mình.
    protected function resolveLecturerId(Request $request, ?int $lecturerId): int
    {
        if ($request->user()->isAdmin()) {
            return $lecturerId ?? User::query()->where('role', 'lecturer')->value('id');
        }

        return $request->user()->id;
    }

    // Helper form giữ bộ chọn giảng viên đơn giản.
    protected function lecturersForForm(User $user)
    {
        if ($user->isAdmin()) {
            return User::query()->where('role', 'lecturer')->orderBy('name')->get(['id', 'name']);
        }

        return collect([$user->only(['id', 'name'])]);
    }
}
