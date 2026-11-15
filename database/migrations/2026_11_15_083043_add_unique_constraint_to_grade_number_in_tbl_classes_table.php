<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_classes', function (Blueprint $table) {
            $table->unique(
                'grade_number',
                'tbl_classes_grade_number_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('tbl_classes', function (Blueprint $table) {
            $table->dropUnique('tbl_classes_grade_number_unique');
        });
    }
};