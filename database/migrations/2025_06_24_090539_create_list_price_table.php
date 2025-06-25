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
        Schema::create('list_price', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
            $table->enum('type', ['b2b', 'b2c'])->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('shelf_price', 10, 2)->default(0);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->integer('min_quantity_to_order')->default(0);
            $table->integer('max_quantity_to_order')->default(0);
            $table->integer('trade_loader')->default(0);
            $table->integer('trade_loader_quantity')->default(0);
            $table->string('UOM', 10);
            $table->tinyInteger('EA')->default(0);
            $table->tinyInteger('CA')->default(0);
            $table->tinyInteger('PL')->default(0);
            // Visibility Flags
            $table->tinyInteger('hidden')->default(0);
            $table->tinyInteger('automatic_hide')->default(0);
            $table->tinyInteger('cancelled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_price');
    }
};
