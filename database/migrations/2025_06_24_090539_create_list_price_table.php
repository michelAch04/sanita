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
            $table->enum('type', ['b2b', 'b2c'])->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('shelf_price', 10, 2)->default(0);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->integer('min_quantity_to_order')->default(0);
            $table->integer('max_quantity_to_order')->default(0);
            $table->integer('trade_loader')->default(0);
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
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
