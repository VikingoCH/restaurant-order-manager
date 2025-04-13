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
        Schema::create('locations', function (Blueprint $table)
        {
            $table->id();
            $table->string('name', length: 50);
            $table->timestamps();
        });

        Schema::create('places', function (Blueprint $table)
        {
            $table->id();
            $table->integer('number');
            $table->boolean('available');
            $table->foreignId('location_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table)
        {
            $table->id();
            $table->string('number', length: 50);
            $table->decimal('total', total: 8, places: 2);
            $table->boolean('is_open')->default(false);
            $table->foreignId('place_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payment_methods', function (Blueprint $table)
        {
            $table->id();
            $table->string('name', length: 50);
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table)
        {
            $table->id();
            $table->string('number', length: 50);
            $table->decimal('total', total: 8, places: 2);
            $table->decimal('discount', total: 4, places: 2);
            $table->decimal('tip', total: 4, places: 2);
            $table->decimal('tax', total: 4, places: 2);
            $table->boolean('paid')->default(false);
            $table->foreignId('order_id')->constrained();
            $table->foreignId('payment_method_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('order_items', function (Blueprint $table)
        {
            $table->id();
            $table->integer('quantity');
            $table->decimal('total', total: 8, places: 2);
            $table->boolean('printed')->default(false);
            $table->string('sides');
            $table->string('remarks');
            $table->foreignId('order_id')->constrained();
            $table->foreignId('menu_item_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('places');
        Schema::dropIfExists('locations');
    }
};
