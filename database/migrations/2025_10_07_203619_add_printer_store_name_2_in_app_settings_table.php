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
        Schema::table('app_settings', function (Blueprint $table)
        {
            $table->renameColumn('printer_store_name', 'printer_store_name_1');
            $table->string('printer_store_name_2', length: 50)->default('Dübendorf')->after('printer_store_name_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table)
        {
            //
        });
    }
};
