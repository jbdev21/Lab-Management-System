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
        Schema::table('bank_check_histories', function (Blueprint $table) {
            $table->unsignedBigInteger("fund_id")->after("status")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_check_histories', function (Blueprint $table) {
            $table->dropColumn("fund_id");
        });
    }
};
