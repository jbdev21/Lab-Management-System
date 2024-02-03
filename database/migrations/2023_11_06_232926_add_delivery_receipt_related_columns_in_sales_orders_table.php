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
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->string("delivery_receipt_number")->nullable()->after("type");
            $table->unsignedBigInteger("delivery_receipt_user")->nullable()->after("delivery_receipt_number");
            $table->timestamp("delivery_receipt_date_time")->nullable()->after("delivery_receipt_user");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn('delivery_receipt_number');
            $table->dropColumn('delivery_receipt_user');
            $table->dropColumn('delivery_receipt_date_time');
        });
    }
};
