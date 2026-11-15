
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_subject_id')
                ->constrained('tbl_class_subjects')
                ->cascadeOnDelete();

            $table->string('title', 200);
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->string('cover_image')->nullable();
            $table->string('pdf_path')->nullable();

            $table->string('academic_year', 9)->nullable();

            $table->unsignedInteger('total_pages')->nullable();

            $table->string('source_type', 20)->default('manual');

            $table->string('status', 20)->default('draft');

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_books');
    }
};
