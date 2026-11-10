<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            // Course URL
            $table->string('slug')->nullable()->unique();

            // Short course introduction
            $table->string('short_description', 500)->nullable();

            // Course thumbnail image
            $table->string('thumbnail')->nullable();

            // Free demo video
            $table->string('demo_video_path')->nullable();

            // Course publication status
            $table->boolean('is_published')->default(false);

            // Course publication date
            $table->timestamp('published_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->dropUnique(['slug']);

            $table->dropColumn([
                'slug',
                'short_description',
                'thumbnail',
                'demo_video_path',
                'is_published',
                'published_at',
            ]);
        });
    }
};
