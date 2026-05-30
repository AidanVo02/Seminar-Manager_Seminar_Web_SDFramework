<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiChatConversation extends Model
{
    // Conversation lưu lịch sử chat AI của một người dùng.
    protected $fillable = [
        'user_id',
        'title',
        'last_response_id',
    ];

    public function user(): BelongsTo
    {
        // Chủ sở hữu của hội thoại.
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        // Danh sách tin nhắn trong hội thoại theo thứ tự.
        return $this->hasMany(AiChatMessage::class, 'conversation_id');
    }
}
