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
    Schema::create('tbl_lessons', function (Blueprint $table) {
        $table->id();

        $table->foreignId('chapter_id')
            ->constrained('tbl_chapters')
            ->cascadeOnDelete();

        $table->string('title');
        $table->text('description')->nullable();
        $table->unsignedInteger('lesson_number');
        $table->unsignedInteger('estimated_minutes')->default(15);
        $table->boolean('is_published')->default(false);
        $table->timestamps();

        $table->unique(['chapter_id', 'lesson_number']);
    });
}

public function down(): void
{
    Schema::dropIfExists('tbl_lessons');
}
};
