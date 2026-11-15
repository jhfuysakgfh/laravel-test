<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIMessage extends Model
{
    protected $table = 'tbl_ai_messages';

    protected $fillable = [
        'session_id',
        'role',
        'content',
        'language',
        'provider',
        'model',
        'input_tokens',
        'output_tokens',
        'safety_status',
    ];

    protected function casts(): array
    {
        return [
            'input_tokens' => 'integer',
            'output_tokens' => 'integer',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(AISession::class, 'session_id');
    }
}
