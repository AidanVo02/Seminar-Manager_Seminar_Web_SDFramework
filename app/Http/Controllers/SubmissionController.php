<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Submission;
use App\Support\ActivityLogger;
use App\Support\SeminarNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubmissionController extends Controller
{
    // Mỗi đăng ký chỉ có một báo cáo; các bản nộp lại được theo dõi bằng revision.
    public function store(Request $request, Registration $registration): RedirectResponse
    {
        $this->authorizeStudent($request, $registration);

        // Validate file cơ bản để demo ổn định và an toàn.
        $data = $request->validate([
            'report' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        // Xóa file cũ nếu đây là lần nộp thay thế.
        if ($registration->submission) {
            Storage::disk('local')->delete($registration->submission->file_path);
        }

        // Số revision giúp lần nộp lại hiển thị rõ trên giao diện.
        $file = $data['report'];
        $path = $file->store('seminar-reports', 'local');
        $nextRevision = ($registration->submission?->revision_number ?? 0) + 1;

        // updateOrCreate giữ submission luôn gắn với registration.
        $submission = $registration->submission()->updateOrCreate([], [
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType() ?? $file->getMimeType() ?? 'application/octet-stream',
            'submitted_at' => now(),
            'note' => $data['note'] ?? null,
            'review_status' => 'submitted',
            'review_note' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'revision_number' => $nextRevision,
        ]);

        $submission->load('registration.topic.lecturer', 'registration.student', 'reviewer');
        SeminarNotifier::reportUploaded($submission);
        ActivityLogger::log(
            $request->user(),
            $nextRevision > 1 ? 'submission.resubmitted' : 'submission.uploaded',
            "{$request->user()->name} uploaded report {$submission->original_name} for {$registration->topic->title}.",
            $submission,
            $this->activityContext($registration, [
                'review_status' => $submission->review_status,
                'revision_number' => $submission->revision_number,
            ])
        );

        return back()->with('status', 'Report uploaded successfully.');
    }

    // Tải xuống được phép cho sinh viên sở hữu, giảng viên hoặc admin.
    public function download(Request $request, Submission $submission): StreamedResponse
    {
        $registration = $submission->registration;
        $user = $request->user();

        abort_unless(
            $user->isAdmin()
            || ($user->isLecturer() && $registration->topic->lecturer_id === $user->id)
            || ($user->isStudent() && $registration->student_id === $user->id),
            403
        );

        return Storage::disk('local')->download($submission->file_path, $submission->original_name);
    }

    // Sinh viên có thể xóa báo cáo của chính mình; admin cũng quản lý được.
    public function destroy(Request $request, Submission $submission): RedirectResponse
    {
        $registration = $submission->registration;
        $user = $request->user();

        abort_unless(
            ($user->isStudent() && $registration->student_id === $user->id)
            || $user->isAdmin(),
            403
        );

        $path = $submission->file_path;

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }

        $submission->delete();
        $registration->load('topic.lecturer', 'student');
        SeminarNotifier::reportDeleted($registration);
        ActivityLogger::log(
            $user,
            'submission.deleted',
            "{$user->name} deleted the seminar report for {$registration->topic->title}.",
            $registration,
            $this->activityContext($registration)
        );

        return back()->with('status', 'Report deleted successfully.');
    }

    // Luồng review của giảng viên/admin cập nhật trạng thái và ghi chú.
    public function review(Request $request, Submission $submission): RedirectResponse
    {
        $registration = $submission->registration()->with(['topic', 'student'])->firstOrFail();
        $user = $request->user();

        abort_unless(
            $user->isAdmin() || ($user->isLecturer() && $registration->topic->lecturer_id === $user->id),
            403
        );

        $data = $request->validate([
            'review_status' => ['required', 'in:changes_requested,accepted'],
            'review_note' => ['required', 'string', 'max:2000'],
        ]);

        $submission->update([
            'review_status' => $data['review_status'],
            'review_note' => $data['review_note'],
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        $submission->load('registration.topic.lecturer', 'registration.student', 'reviewer');
        SeminarNotifier::reportReviewed($submission);
        ActivityLogger::log(
            $user,
            'submission.reviewed',
            "{$user->name} marked the report for {$registration->student->name} as {$submission->review_status}.",
            $submission,
            $this->activityContext($registration, [
                'review_status' => $submission->review_status,
                'revision_number' => $submission->revision_number,
            ])
        );

        return back()->with('status', 'Submission review saved successfully.');
    }

    // Kiểm tra sinh viên giúp tránh ghi nhầm sang tài khoản khác.
    protected function authorizeStudent(Request $request, Registration $registration): void
    {
        $user = $request->user();

        abort_unless(
            $user->isStudent()
            && $registration->student_id === $user->id
            && in_array($registration->status, ['pending', 'approved'], true),
            403
        );
    }

    // Metadata này được tái sử dụng cho log hoạt động.
    protected function activityContext(Registration $registration, array $extra = []): array
    {
        return array_merge([
            'topic_id' => $registration->topic_id,
            'student_id' => $registration->student_id,
            'lecturer_id' => $registration->topic->lecturer_id,
            'registration_id' => $registration->id,
        ], $extra);
    }
}
