<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Product;
use App\Models\Student;
use App\Models\Profile;
use App\Models\Payment;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}