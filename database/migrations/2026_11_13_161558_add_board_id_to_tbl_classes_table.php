<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_classes', function (Blueprint $table) {
            // Temporarily nullable to preserve existing class records.
            $table->foreignId('board_id')
                ->nullable()
                ->constrained('boards')
                ->nullOnDelete();

            // Remove the old global uniqueness rule.
            $table->dropUnique(['grade_number']);

            // A grade can repeat across different boards,
            // but not within the same board.
            $table->unique(['board_id', 'grade_number']);
        });
    }

    public function down(): void
    {
        Schema::table('tbl_classes', function (Blueprint $table) {
            $table->dropUnique(['board_id', 'grade_number']);
            $table->dropForeign(['board_id']);
            $table->dropColumn('board_id');

            // Restore the original uniqueness rule.
            $table->unique('grade_number');
        });
    }
};