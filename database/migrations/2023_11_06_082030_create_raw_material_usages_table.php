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
        Schema::create('raw_material_usage', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('raw_material_id');
            $table->unsignedBigInteger('usage_id');
            $table->decimal('quantity', 10, 2);
            $table->timestamps();

            $table->foreign('raw_material_id')->references('id')->on('raw_materials');
            $table->foreign('usage_id')->references('id')->on('usages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_usage');
    }
};
