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
    Schema::create('tbl_chapters', function (Blueprint $table) {
        $table->id();

        $table->foreignId('class_subject_id')
            ->constrained('tbl_class_subjects')
            ->cascadeOnDelete();

        $table->string('title');
        $table->text('description')->nullable();
        $table->unsignedInteger('chapter_number');
        $table->boolean('is_published')->default(false);
        $table->timestamps();

        $table->unique(['class_subject_id', 'chapter_number']);
    });
}

public function down(): void
{
    Schema::dropIfExists('tbl_chapters');
}
};
