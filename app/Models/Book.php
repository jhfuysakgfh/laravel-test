<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $table = 'tbl_books';

    protected $fillable = [
        'class_subject_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'pdf_path',
        'academic_year',
        'total_pages',
        'source_type',
        'status',
        'approved_at',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'total_pages' => 'integer',
            'approved_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class, 'book_id')
            ->orderBy('chapter_number');
    }
}
