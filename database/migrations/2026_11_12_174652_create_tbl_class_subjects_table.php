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
    Schema::create('tbl_class_subjects', function (Blueprint $table) {
        $table->id();

        $table->foreignId('class_id')
            ->constrained('tbl_classes')
            ->cascadeOnDelete();

        $table->foreignId('subject_id')
            ->constrained('tbl_subjects')
            ->cascadeOnDelete();

        $table->timestamps();

        $table->unique(['class_id', 'subject_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('tbl_class_subjects');
}
};
