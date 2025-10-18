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
            $table->date('cash_closing_at')->nullable();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('payment_method_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transaction_items', function (Blueprint $table)
        {
            $table->id();
            $table->string('item', length: 150);
            $table->integer('quantity');
            $table->decimal('price', total: 8, places: 2);
            $table->foreignId('transaction_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
