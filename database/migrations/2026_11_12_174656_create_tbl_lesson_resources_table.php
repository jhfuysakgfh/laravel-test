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
    Schema::create('tbl_lesson_resources', function (Blueprint $table) {
        $table->id();

        $table->foreignId('lesson_id')
            ->constrained('tbl_lessons')
            ->cascadeOnDelete();

        $table->string('resource_type'); // image, video, audio, pdf
        $table->string('title')->nullable();
        $table->string('file_path');
        $table->string('language', 10)->default('both');
        $table->unsignedInteger('sort_order')->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('tbl_lesson_resources');
}
};
