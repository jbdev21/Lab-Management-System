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
        Schema::create('delivers', function (Blueprint $table) {
            $table->id();
            $table->integer('percentage')->default(100)->comment('this is for the percentage of being put in based on the items in purchase order');
            $table->unsignedBigInteger('purchase_order_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('reference')->index();
            $table->text('note')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivers');
    }
};
