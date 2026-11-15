
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_ai_video_generations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lesson_id')
                ->constrained('tbl_lessons')
                ->cascadeOnDelete();

            // Video configuration
            $table->string('video_style')->default('mixed');
            $table->string('language', 10); // en or hi

            // AI provider information
            $table->string('provider')->nullable();
            $table->string('provider_job_id')->nullable();

            // Generation input
            $table->longText('generation_prompt')->nullable();
            $table->longText('video_script')->nullable();
            $table->json('generation_settings')->nullable();

            // Generation status
            $table->string('status')->default('pending');
            // pending, processing, completed, failed

            // Generated video
            $table->string('output_path')->nullable();

            // Error tracking
            $table->text('error_message')->nullable();

            // Processing timestamps
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['lesson_id', 'language']);
            $table->index('status');
            $table->index('provider_job_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_ai_video_generations');
    }
};
