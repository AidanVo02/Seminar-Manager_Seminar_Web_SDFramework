<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\Submission;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_topics_index(): void
    {
        $response = $this->get(route('topics.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_student_cannot_open_topic_creation_page(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->get(route('topics.create'));

        $response->assertForbidden();
    }

    public function test_lecturer_cannot_access_user_management(): void
    {
        $lecturer = User::factory()->create(['role' => 'lecturer']);

        $response = $this->actingAs($lecturer)->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_download_any_report_and_delete_it(): void
    {
        Storage::fake('local');
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $lecturer = User::factory()->create(['role' => 'lecturer']);
        $student = User::factory()->create(['role' => 'student']);

        $topic = Topic::create([
            'title' => 'Permissions topic',
            'description' => 'A detailed description used to validate report permissions.',
            'lecturer_id' => $lecturer->id,
            'status' => 'open',
        ]);

        $registration = Registration::create([
            'topic_id' => $topic->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        $submission = $registration->submission()->create([
            'original_name' => 'report.pdf',
            'file_path' => 'seminar-reports/report.pdf',
            'mime_type' => 'application/pdf',
            'submitted_at' => now(),
            'note' => 'Demo report',
            'review_status' => 'submitted',
            'revision_number' => 1,
        ]);

        Storage::disk('local')->put($submission->file_path, 'demo');

        $download = $this->actingAs($admin)->get(route('submissions.download', $submission));
        $download->assertOk();

        $delete = $this->actingAs($admin)->delete(route('submissions.destroy', $submission));
        $delete->assertRedirect();
        $this->assertDatabaseMissing('submissions', ['id' => $submission->id]);
    }

    public function test_lecturer_can_download_supervised_report_but_cannot_delete_it(): void
    {
        Storage::fake('local');
        Mail::fake();

        $lecturer = User::factory()->create(['role' => 'lecturer']);
        $student = User::factory()->create(['role' => 'student']);

        $topic = Topic::create([
            'title' => 'Lecturer report topic',
            'description' => 'A detailed description used to validate lecturer report permissions.',
            'lecturer_id' => $lecturer->id,
            'status' => 'open',
        ]);

        $registration = Registration::create([
            'topic_id' => $topic->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        $submission = $registration->submission()->create([
            'original_name' => 'lecturer-report.pdf',
            'file_path' => 'seminar-reports/lecturer-report.pdf',
            'mime_type' => 'application/pdf',
            'submitted_at' => now(),
            'note' => 'Demo report',
            'review_status' => 'submitted',
            'revision_number' => 1,
        ]);

        Storage::disk('local')->put($submission->file_path, 'demo');

        $download = $this->actingAs($lecturer)->get(route('submissions.download', $submission));
        $download->assertOk();

        $delete = $this->actingAs($lecturer)->delete(route('submissions.destroy', $submission));
        $delete->assertForbidden();
    }

    public function test_student_can_download_and_delete_own_report(): void
    {
        Storage::fake('local');
        Mail::fake();

        $student = User::factory()->create(['role' => 'student']);
        $lecturer = User::factory()->create(['role' => 'lecturer']);

        $topic = Topic::create([
            'title' => 'Student report topic',
            'description' => 'A detailed description used to validate student report permissions.',
            'lecturer_id' => $lecturer->id,
            'status' => 'open',
        ]);

        $registration = Registration::create([
            'topic_id' => $topic->id,
            'student_id' => $student->id,
            'status' => 'approved',
        ]);

        $submission = $registration->submission()->create([
            'original_name' => 'student-report.pdf',
            'file_path' => 'seminar-reports/student-report.pdf',
            'mime_type' => 'application/pdf',
            'submitted_at' => now(),
            'note' => 'Demo report',
            'review_status' => 'submitted',
            'revision_number' => 1,
        ]);

        Storage::disk('local')->put($submission->file_path, 'demo');

        $download = $this->actingAs($student)->get(route('submissions.download', $submission));
        $download->assertOk();

        $delete = $this->actingAs($student)->delete(route('submissions.destroy', $submission));
        $delete->assertRedirect();
        $this->assertDatabaseMissing('submissions', ['id' => $submission->id]);
    }
}
