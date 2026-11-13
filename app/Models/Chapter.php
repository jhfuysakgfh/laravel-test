<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    protected $table = 'tbl_chapters';

    protected $fillable = [
        'class_subject_id',
        'title',
        'description',
        'chapter_number',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'chapter_number' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'chapter_id')
            ->orderBy('lesson_number');
    }
}