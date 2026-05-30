<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Topic;
use App\Support\ActivityLogger;
use App\Support\SeminarNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Đăng ký của sinh viên là điểm vào của luồng seminar.
    public function store(Request $request, Topic $topic): RedirectResponse
    {
        abort_unless($request->user()->isStudent(), 403);

        // Topic phải mở thì sinh viên mới có thể tham gia.
        if ($topic->status !== 'open') {
            return back()->with('status', 'This topic is closed for registration.');
        }

        // Capacity giúp demo không bị đăng ký vượt giới hạn.
        if ($topic->registrations()->count() >= $topic->capacity) {
            return back()->with('status', 'This topic has reached its registration capacity.');
        }

        // firstOrNew tránh tạo trùng đăng ký giữa sinh viên và topic.
        $registration = Registration::firstOrNew(
            [
                'topic_id' => $topic->id,
                'student_id' => $request->user()->id,
            ],
            [
                'status' => 'pending',
            ]
        );

        $created = ! $registration->exists;

        if ($created) {
            $registration->save();
        }

        $registration->load(['topic.lecturer', 'student']);

        // Chỉ khi đăng ký mới thì mới gửi thông báo và ghi log.
        if ($created) {
            SeminarNotifier::registrationSubmitted($registration);
            ActivityLogger::log(
                $request->user(),
                'registration.submitted',
                "{$request->user()->name} registered for {$topic->title}.",
                $registration,
                [
                    'topic_id' => $topic->id,
                    'student_id' => $request->user()->id,
                    'lecturer_id' => $topic->lecturer_id,
                    'registration_status' => $registration->status,
                ]
            );
        }

        return back()->with('status', $created ? 'Your topic registration has been submitted.' : 'You have already registered for this topic.');
    }

    // Giảng viên/admin có thể duyệt hoặc từ chối đăng ký.
    public function updateStatus(Request $request, Registration $registration): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->isAdmin() || ($user->isLecturer() && $registration->topic->lecturer_id === $user->id), 403);

        // Trạng thái chỉ giới hạn trong một tập nhỏ để dễ kiểm soát.
        $data = $request->validate([
            'status' => ['required', 'in:approved,rejected,pending'],
        ]);

        // Mọi cập nhật đều được ghi log vì nó làm thay đổi trạng thái seminar.
        $registration->update($data);
        $registration->load(['topic', 'student']);
        SeminarNotifier::registrationStatusUpdated($registration);
        ActivityLogger::log(
            $user,
            'registration.status_updated',
            "{$user->name} set {$registration->student->name}'s registration for {$registration->topic->title} to {$registration->status}.",
            $registration,
            [
                'topic_id' => $registration->topic_id,
                'student_id' => $registration->student_id,
                'lecturer_id' => $registration->topic->lecturer_id,
                'registration_status' => $registration->status,
            ]
        );

        return back()->with('status', 'Registration status updated successfully.');
    }
}
