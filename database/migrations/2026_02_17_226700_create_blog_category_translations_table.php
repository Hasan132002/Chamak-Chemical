<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_category_id');
            $table->string('locale', 2);
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->unique(['blog_category_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_category_translations');
    }
};
