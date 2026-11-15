<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIVideoGeneration extends Model
{
    protected $table = 'tbl_ai_video_generations';

    protected $fillable = [
        'lesson_id',
        'video_style',
        'language',
        'provider',
        'provider_job_id',
        'generation_prompt',
        'video_script',
        'generation_settings',
        'status',
        'output_path',
        'error_message',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'generation_settings' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
