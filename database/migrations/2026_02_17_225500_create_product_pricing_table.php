<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique();
            $table->decimal('retail_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->date('sale_start_date')->nullable();
            $table->date('sale_end_date')->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_pricing');
    }
};
