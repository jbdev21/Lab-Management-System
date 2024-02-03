<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('acknowledgement_receipts', function (Blueprint $table) {
            $table->date('date_issued')->after('amount');
            $table->enum('type', ['Acknowledgement Receipt', 'Counter Receipt'])
                ->default('Acknowledgement Receipt')
                ->after('date_issued');
        });
    }

    public function down()
    {
        Schema::table('acknowledgement_receipts', function (Blueprint $table) {
            $table->dropColumn('date_issued');
            $table->dropColumn('type');
        });
    }
};
