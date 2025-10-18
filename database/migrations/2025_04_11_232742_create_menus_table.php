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
        Schema::create('menu_sections', function (Blueprint $table)
        {
            $table->id();
            $table->integer('position');
            $table->string('name', length: 150);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menu_sides', function (Blueprint $table)
        {
            $table->id();
            $table->string('name', length: 150);
            $table->integer('position')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('printers', function (Blueprint $table)
        // {
        //     $table->id();
        //     $table->string('name', length: 150);
        //     $table->string('identifier', length: 150);
        //     $table->string('location', length: 150);
        //     $table->string('ip_address', length: 20);
        //     $table->string('conection_type', length: 50);
        //     $table->timestamps();
        // });

        Schema::create('menu_items', function (Blueprint $table)
        {
            $table->id();
            $table->integer('position');
            $table->string('name', length: 150);
            $table->decimal('price', total: 8, places: 2);
            $table->string('image_path')->nullable();
            $table->foreignId('menu_section_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('printer_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menu_fixed_sides', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('menu_side_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('menu_selectable_sides', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('menu_side_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_selectable_sides');
        Schema::dropIfExists('menu_fixed_sides');
        Schema::dropIfExists('menu_items');
        // Schema::dropIfExists('printers');
        Schema::dropIfExists('menu_sides');
        Schema::dropIfExists('menu_sections');
    }
};
