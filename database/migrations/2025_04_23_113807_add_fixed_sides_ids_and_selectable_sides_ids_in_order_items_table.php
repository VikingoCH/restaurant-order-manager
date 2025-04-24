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
        Schema::table('order_items', function (Blueprint $table)
        {
            $table->string('fixed_sides', length: 50)->nullable()->after('remarks');
            $table->string('selectable_sides', length: 50)->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table)
        {
            $table->dropColumn(['fixed_sides', 'selectable_sides']);
        });
    }
};
