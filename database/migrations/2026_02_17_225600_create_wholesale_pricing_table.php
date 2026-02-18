<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wholesale_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->enum('dealer_tier', ['bronze', 'silver', 'gold', 'platinum']);
            $table->integer('min_quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index(['product_id', 'dealer_tier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wholesale_pricing');
    }
};
