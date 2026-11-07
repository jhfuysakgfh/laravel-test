<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class Student extends Model
{
    protected $fillable = [
        'name',
        'roll_no',
        'section',
        'class',
        'email',
        'image',
    ];

    public function user()
    {   
        return $this->belongsTo(User::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }
}
