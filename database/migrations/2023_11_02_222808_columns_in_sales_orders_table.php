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
            $table->date('effectivity_date')->index();
            $table->string('so_number')->nullable()->index();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('customer_id')->index();
            $table->integer('term');
            $table->double('amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('freight')->nullable();
            $table->double('net')->nullable();
            $table->string('status')->default("draft"); // draft and published
            $table->string('type'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn('so_number')->index();
            $table->dropColumn('agent_id')->nullable();
            $table->dropColumn('customer_id');
            $table->dropColumn('term');
            $table->dropColumn('amount');
            $table->dropColumn('discount');
            $table->dropColumn('freight');
            $table->dropColumn('net');
            $table->dropColumn('status');
            $table->dropColumn('type'); 
        });
    }
};
