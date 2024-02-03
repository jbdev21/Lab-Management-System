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
        Schema::create('bank_checks', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('bank');
            $table->date('check_date');
            $table->unsignedBigInteger('bankCheckable_id');
            $table->string('bankCheckable_type');
            $table->timestamps();

            $table->index(['bankCheckable_id', 'bankCheckable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_checks');
    }
};
