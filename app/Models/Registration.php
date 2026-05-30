<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Registration extends Model
{
    // Registration là bản ghi trung tâm của toàn bộ quy trình seminar.
    protected $fillable = [
        'topic_id',
        'student_id',
        'status',
    ];

    public function topic(): BelongsTo
    {
        // Topic mà sinh viên đã chọn.
        return $this->belongsTo(Topic::class);
    }

    public function student(): BelongsTo
    {
        // Sinh viên sở hữu registration này.
        return $this->belongsTo(User::class, 'student_id');
    }

    public function presentation(): HasOne
    {
        // Lịch bảo vệ tùy chọn gắn với registration.
        return $this->hasOne(Presentation::class);
    }

    public function score(): HasOne
    {
        // Điểm cuối cùng cho bản ghi seminar.
        return $this->hasOne(Score::class);
    }

    public function submission(): HasOne
    {
        // File báo cáo và trạng thái review.
        return $this->hasOne(Submission::class);
    }

    public function activityLogs(): MorphMany
    {
        // Các log tham chiếu registration này làm đối tượng.
        return $this->morphMany(ActivityLog::class, 'subject');
    }
}
