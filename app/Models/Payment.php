<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'amount',
        'status',
        'method',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }
}