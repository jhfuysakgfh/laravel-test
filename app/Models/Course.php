<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'thumbnail',
        'demo_video_path',
        'is_published',
        'published_at',
    ];

    public function students()
{
    return $this->belongsToMany(Student::class)->withTimestamps();
}
public function sections(): HasMany
{
    return $this->hasMany(CourseSection::class)->orderBy('sort_order');
}
protected function casts(): array
{
    return [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}