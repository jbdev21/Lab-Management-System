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
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('percentage')->default(100)->comment('this is for the percentage of being put in based on the products in sales order');
            $table->unsignedBigInteger('sales_order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('dr_number');
            $table->string('note')->nullable();
            $table->string('status')->default("draft"); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_receipts');
    }
};
