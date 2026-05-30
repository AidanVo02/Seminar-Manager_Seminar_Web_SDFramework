<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presentation extends Model
{
    // Presentation lưu ngày bảo vệ và phòng bảo vệ.
    protected $fillable = [
        'registration_id',
        'scheduled_at',
        'room',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
        ];
    }

    public function registration(): BelongsTo
    {
        // Presentation thuộc về một registration đã được duyệt.
        return $this->belongsTo(Registration::class);
    }
}
