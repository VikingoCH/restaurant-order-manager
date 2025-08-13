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
            $table->string('printer_store_website', length: 100)->default('picahna-brasil.ch')->after('rows_per_page');
            $table->string('printer_store_email', length: 100)->default('info@picahna-brasil.ch')->after('rows_per_page');
            $table->string('printer_store_phone', length: 20)->default('+41 44 821 64 31')->after('rows_per_page');
            $table->string('printer_store_address', length: 250)->default('Wangenstrasse 37, 8600 Dübendorf, CH')->after('rows_per_page');
            $table->string('printer_store_name', length: 50)->default('Picanha Brasil - Dübendorf')->after('rows_per_page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table)
        {
            $table->dropColumn('printer_store_website');
            $table->dropColumn('printer_store_email');
            $table->dropColumn('printer_store_phone');
            $table->dropColumn('printer_store_address');
            $table->dropColumn('printer_store_name');
        });
    }
};
