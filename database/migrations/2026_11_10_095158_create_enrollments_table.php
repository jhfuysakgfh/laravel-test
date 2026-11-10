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
    Schema::create('enrollments', function (Blueprint $table) {
        $table->id();

        // Student account
        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        // Purchased course
        $table->foreignId('course_id')
            ->constrained('courses')
            ->cascadeOnDelete();

        // Associated payment
        $table->foreignId('payment_id')
            ->nullable()
            ->constrained('payments')
            ->nullOnDelete();

        // Enrollment access status
        $table->string('status')->default('active');

        // Enrollment and expiry dates
        $table->timestamp('enrolled_at')->useCurrent();
        $table->timestamp('expires_at')->nullable();

        $table->timestamps();

        // Prevent duplicate enrollment for the same student and course
        $table->unique(['user_id', 'course_id']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
