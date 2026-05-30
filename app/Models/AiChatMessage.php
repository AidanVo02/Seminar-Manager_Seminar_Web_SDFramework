<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiChatMessage extends Model
{
    // Message lưu một lượt trao đổi của người dùng hoặc trợ lý.
    protected $fillable = [
        'conversation_id',
        'role',
        'content',
        'response_id',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    public function conversation(): BelongsTo
    {
        // Hội thoại cha sở hữu tin nhắn này.
        return $this->belongsTo(AiChatConversation::class, 'conversation_id');
    }
}
