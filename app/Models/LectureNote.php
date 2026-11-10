<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureNote extends Model
{
    protected $fillable = [
        'lecture_id',
        'title',
        'file_path',
        'file_size',
        'sort_order',
    ];

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }
}