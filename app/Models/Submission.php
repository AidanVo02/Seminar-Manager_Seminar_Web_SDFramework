<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Submission extends Model
{
    // Submission lưu báo cáo đã upload và vòng đời review của nó.
    protected $fillable = [
        'registration_id',
        'original_name',
        'file_path',
        'mime_type',
        'submitted_at',
        'note',
        'review_status',
        'review_note',
        'reviewed_by',
        'reviewed_at',
        'revision_number',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function registration(): BelongsTo
    {
        // Registration cha quyết định quyền sở hữu và quyền truy cập.
        return $this->belongsTo(Registration::class);
    }

    public function reviewer(): BelongsTo
    {
        // Giảng viên/admin đã review báo cáo.
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function activityLogs(): MorphMany
    {
        // Các mục activity gắn với vòng đời submission.
        return $this->morphMany(ActivityLog::class, 'subject');
    }
}
