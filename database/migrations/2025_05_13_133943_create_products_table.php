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
            // Primary & Position
            $table->id();
            $table->unsignedInteger('position')->default(9999);

            // Identifiers
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('extension')->nullable();

            // Names (Multilingual)
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('name_ku');

            // Small Descriptions (Multilingual)
            $table->text('small_description_en')->nullable();
            $table->text('small_description_ar')->nullable();
            $table->text('small_description_ku')->nullable();

            $table->integer('EA-CA');
            $table->integer('EA-PA');

            // Classification Codes
            $table->string('product_line_code')->nullable();
            $table->string('product_line_description')->nullable();
            $table->string('family_code')->nullable();
            $table->string('family_description')->nullable();

            // Foreign Keys
            $table->foreignId('subcategories_id')->constrained('subcategories')->onDelete('cascade');
            $table->foreignId('brands_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('tax_id')->nullable()->constrained('taxes')->nullOnDelete();


            // Timestamps
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
