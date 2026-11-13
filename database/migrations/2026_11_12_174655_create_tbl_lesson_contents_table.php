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
    Schema::create('tbl_lesson_contents', function (Blueprint $table) {
        $table->id();

        $table->foreignId('lesson_id')
            ->constrained('tbl_lessons')
            ->cascadeOnDelete();

        $table->string('language', 10); // en or hi
        $table->longText('content')->nullable();
        $table->longText('learning_objectives')->nullable();
        $table->longText('key_points')->nullable();
        $table->timestamps();

        $table->unique(['lesson_id', 'language']);
    });
}

public function down(): void
{
    Schema::dropIfExists('tbl_lesson_contents');
}
};
