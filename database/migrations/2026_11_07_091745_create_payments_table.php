<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Which user initiated the payment?
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Razorpay order and payment identifiers
            $table->string('razorpay_order_id')->unique();
            $table->string('razorpay_payment_id')->nullable()->unique();

            // Payment amount in INR
            $table->decimal('amount', 10, 2);

            // Payment status
            $table->string('status')->default('created');

            // Payment method (UPI, card, netbanking, etc.)
            $table->string('method')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
