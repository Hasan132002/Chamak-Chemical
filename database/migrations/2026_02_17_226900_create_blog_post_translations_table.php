<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_post_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_post_id');
            $table->string('locale', 2);
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();

            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
            $table->unique(['blog_post_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_translations');
    }
};
