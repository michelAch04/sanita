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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('extension')->nullable();
            $table->string('sku')->unique();
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('small_description', 255)->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('shelf_price', 10, 2)->default(0);
            $table->integer('threshold')->default(0);
            $table->string('product_line_code')->nullable();
            $table->string('product_line_description')->nullable();
            $table->string('family_code')->nullable();
            $table->string('family_description')->nullable();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->tinyInteger('tax')->default(0);
            $table->integer('available_quantity')->default(0);
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
        Schema::dropIfExists('products');
    }
};
