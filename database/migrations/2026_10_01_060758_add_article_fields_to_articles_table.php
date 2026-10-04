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
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('author_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('title', 255);
            $table->string('slug', 255)->unique();

            $table->text('excerpt')->nullable();
            $table->longText('content');

            $table->string('featured_image')->nullable();

            $table->string('status', 20)->default('draft');

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking')->default(false);

            $table->unsignedBigInteger('views_count')->default(0);

            $table->unsignedSmallInteger('reading_time_minutes')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->dateTime('published_at')->nullable();

            $table->softDeletes();

            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['author_id']);

            $table->dropUnique(['slug']);

            $table->dropIndex(['status', 'published_at']);

            $table->dropColumn([
                'author_id',
                'title',
                'slug',
                'excerpt',
                'content',
                'featured_image',
                'status',
                'is_featured',
                'is_breaking',
                'views_count',
                'reading_time_minutes',
                'meta_title',
                'meta_description',
                'published_at',
                'deleted_at',
            ]);
        });
    }
};
