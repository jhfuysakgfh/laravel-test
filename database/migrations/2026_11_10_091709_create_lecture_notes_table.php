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
    Schema::create('lecture_notes', function (Blueprint $table) {
        $table->id();

        // Connect notes to a lecture
        $table->foreignId('lecture_id')
            ->constrained('lectures')
            ->cascadeOnDelete();

        $table->string('title');

        // Store the PDF file path
        $table->string('file_path');

        // File size in bytes
        $table->unsignedBigInteger('file_size')->default(0);

        // Display order
        $table->unsignedInteger('sort_order')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_notes');
    }
};
