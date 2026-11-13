<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $table = 'tbl_lessons';

    protected $fillable = [
        'chapter_id',
        'title',
        'description',
        'lesson_number',
        'estimated_minutes',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'lesson_number' => 'integer',
            'estimated_minutes' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(LessonContent::class, 'lesson_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(LessonResource::class, 'lesson_id')
            ->orderBy('sort_order');
    }
}