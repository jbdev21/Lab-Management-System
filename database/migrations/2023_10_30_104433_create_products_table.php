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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('abbreviation');
            $table->text('description');
            $table->string('unit');
            $table->string('type');
            $table->decimal('factory_price', 10, 2);
            $table->decimal('dealer_price', 10, 2);
            $table->decimal('farm_price', 10, 2);
            $table->timestamps();

            //indexing
            $table->index('abbreviation');
            $table->index('brand_name');
            $table->index('type');
            $table->index('unit');
            $table->index('factory_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
