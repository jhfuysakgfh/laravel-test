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
    Schema::create('lectures', function (Blueprint $table) {
        $table->id();

        // Link lecture to its course section
        $table->foreignId('course_section_id')
            ->constrained('course_sections')
            ->cascadeOnDelete();

        $table->string('title');
        $table->text('description')->nullable();

        // Store the video file path, not the actual video
        $table->string('video_path')->nullable();

        // Video duration in seconds
        $table->unsignedInteger('duration_seconds')->default(0);

        // Free demo lecture or paid lecture
        $table->boolean('is_preview')->default(false);

        // Control lecture visibility
        $table->boolean('is_published')->default(false);

        // Lecture display order
        $table->unsignedInteger('sort_order')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
