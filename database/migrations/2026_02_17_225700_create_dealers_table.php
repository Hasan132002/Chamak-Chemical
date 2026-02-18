<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('business_name');
            $table->string('business_license')->nullable();
            $table->string('tax_id')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->enum('dealer_tier', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze');
            $table->decimal('credit_limit', 10, 2)->default(0);
            $table->integer('payment_terms')->default(30);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->index('approval_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
