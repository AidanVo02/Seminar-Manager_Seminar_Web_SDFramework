<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Guest routes are only for login and are intentionally kept separate.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

// Authenticated routes contain the whole seminar workflow.
Route::middleware('auth')->group(function () {
    // Dashboard and audit log views are available after login.
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // AI chat is a project helper, not a business workflow feature.
    Route::get('/ai-chat', [AiChatController::class, 'index'])->name('ai-chat.index');
    Route::post('/ai-chat', [AiChatController::class, 'store'])->name('ai-chat.store');
    Route::post('/ai-chat/conversations', [AiChatController::class, 'createConversation'])->name('ai-chat.conversations.store');
    Route::get('/ai-chat/conversations/{conversation}', [AiChatController::class, 'showConversation'])->name('ai-chat.conversations.show');

    // Topic management is lecturer/admin scope.
    Route::get('/topics/create', [TopicController::class, 'create'])
        ->middleware('role:lecturer,admin')
        ->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])
        ->middleware('role:lecturer,admin')
        ->name('topics.store');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])
        ->middleware('role:lecturer,admin')
        ->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])
        ->middleware('role:lecturer,admin')
        ->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])
        ->middleware('role:lecturer,admin')
        ->name('topics.destroy');

    // Resource routes keep the read-only topic pages simple.
    Route::resource('topics', TopicController::class)->only(['index', 'show']);
    Route::get('/topics/{topic}/summary', [ExportController::class, 'topicSummary'])
        ->middleware('role:lecturer,admin')
        ->name('topics.summary');

    // Admin-only user management.
    Route::resource('users', UserManagementController::class)
        ->except(['show'])
        ->middleware('role:admin');

    // Student registration is the workflow entry point.
    Route::post('/topics/{topic}/register', [RegistrationController::class, 'store'])
        ->middleware('role:student')
        ->name('registrations.store');

    // Lecturer/admin handle registration status changes.
    Route::patch('/registrations/{registration}/status', [RegistrationController::class, 'updateStatus'])
        ->middleware('role:lecturer,admin')
        ->name('registrations.update-status');

    // Report submission lifecycle.
    Route::post('/registrations/{registration}/submission', [SubmissionController::class, 'store'])
        ->middleware('role:student')
        ->name('submissions.store');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])
        ->name('submissions.destroy');
    Route::get('/submissions/{submission}/download', [SubmissionController::class, 'download'])
        ->name('submissions.download');
    Route::patch('/submissions/{submission}/review', [SubmissionController::class, 'review'])
        ->middleware('role:lecturer,admin')
        ->name('submissions.review');

    // Presentation scheduling is only allowed after approval.
    Route::get('/registrations/{registration}/presentation/create', [PresentationController::class, 'create'])
        ->middleware('role:lecturer,admin')
        ->name('presentations.create');
    Route::post('/registrations/{registration}/presentation', [PresentationController::class, 'store'])
        ->middleware('role:lecturer,admin')
        ->name('presentations.store');
    Route::get('/presentations/{presentation}/edit', [PresentationController::class, 'edit'])
        ->middleware('role:lecturer,admin')
        ->name('presentations.edit');
    Route::put('/presentations/{presentation}', [PresentationController::class, 'update'])
        ->middleware('role:lecturer,admin')
        ->name('presentations.update');

    // Final scoring is also lecturer/admin scope.
    Route::post('/registrations/{registration}/score', [ScoreController::class, 'store'])
        ->middleware('role:lecturer,admin')
        ->name('scores.store');
    Route::put('/scores/{score}', [ScoreController::class, 'update'])
        ->middleware('role:lecturer,admin')
        ->name('scores.update');
});
