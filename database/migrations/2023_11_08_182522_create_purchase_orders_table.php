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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();
            $table->string('supplier_id');
            $table->date('effectivity_date');
            $table->date('due_date')->nullable();
            $table->integer('term');
            $table->double('amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('freight')->nullable();
            $table->double('net')->nullable();
            $table->string('status')->default("draft"); 
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
