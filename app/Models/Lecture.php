<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecture extends Model
{
    protected $fillable = [
        'course_section_id',
        'title',
        'description',
        'video_path',
        'duration_seconds',
        'is_preview',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_preview' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
    public function notes(): HasMany
    {
        return $this->hasMany(LectureNote::class)->orderBy('sort_order');
    }
}