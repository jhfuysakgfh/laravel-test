<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonContent extends Model
{
    protected $table = 'tbl_lesson_contents';

    protected $fillable = [
        'lesson_id',
        'language',
        'content',
        'learning_objectives',
        'key_points',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}