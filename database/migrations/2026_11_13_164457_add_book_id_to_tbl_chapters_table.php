
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_chapters', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->nullable()
                ->constrained('tbl_books')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_chapters', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });
    }
};
