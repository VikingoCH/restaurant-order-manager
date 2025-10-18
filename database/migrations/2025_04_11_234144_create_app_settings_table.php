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
        Schema::create('app_settings', function (Blueprint $table)
        {
            $table->id();
            $table->string('order_prefix')->default('ORD');
            $table->string('quick_order_name')->default('Verschiedene Gerichte');
            $table->decimal('tax', total: 4, places: 2)->default(8.1);
            $table->integer('rows_per_page')->default(10);
            $table->integer('default_printer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
