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
        Schema::create('acknowledgement_receipt_delivery_receipt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acknowledgement_receipt_id');
            $table->unsignedBigInteger('delivery_receipt_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acknowledgement_receipt_delivery_receipt');
    }
};
