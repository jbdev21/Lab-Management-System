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
        Schema::create('price_request_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price_request_id');
            $table->unsignedBigInteger('product_id');
            $table->double('unit_price');
            $table->double('quantity');
            $table->double('discount')->default(0);
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_request_product');
    }
};
