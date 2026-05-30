<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    // ActivityLog là dấu vết kiểm toán cho toàn bộ luồng xử lý.
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        // Người dùng gây ra hoặc kích hoạt hành động.
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        // Liên kết đa hình tới topic, registration, submission, v.v.
        return $this->morphTo();
    }
}
