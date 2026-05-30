<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    // Topic là thực thể seminar mà sinh viên đăng ký tham gia.
    protected $fillable = [
        'title',
        'description',
        'category',
        'capacity',
        'semester',
        'difficulty',
        'expected_outcomes',
        'lecturer_id',
        'status',
    ];

    public function lecturer(): BelongsTo
    {
        // Giảng viên phụ trách topic này.
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function registrations(): HasMany
    {
        // Toàn bộ registration của sinh viên gắn với topic này.
        return $this->hasMany(Registration::class);
    }
}
