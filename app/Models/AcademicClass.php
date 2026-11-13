<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicClass extends Model
{
    protected $table = 'tbl_classes';

    protected $fillable = [
        'name',
        'grade_number',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'grade_number' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function classSubjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'class_id');
    }
}