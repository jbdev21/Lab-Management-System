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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->date('expiration_date');
            $table->date('manufacture_date');
            $table->timestamps();

            // Define foreign key constraint for product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

             //indexing
             $table->index('product_id');
             $table->index('quantity');
             $table->index('expiration_date');
             $table->index('manufacture_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
