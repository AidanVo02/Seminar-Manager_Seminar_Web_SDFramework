<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    // Score lưu kết quả đánh giá cuối cùng của một registration.
    protected $fillable = [
        'registration_id',
        'score',
        'comment',
    ];

    public function registration(): BelongsTo
    {
        // Score thuộc về registration seminar.
        return $this->belongsTo(Registration::class);
    }
}
