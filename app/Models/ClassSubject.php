<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSubject extends Model
{
    protected $table = 'tbl_class_subjects';

    protected $fillable = [
        'class_id',
        'subject_id',
    ];

    public function academicClass(): BelongsTo
    {
        return $this->belongsTo(AcademicClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class, 'class_subject_id');
    }
}