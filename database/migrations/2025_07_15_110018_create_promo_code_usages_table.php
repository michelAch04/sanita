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
        Schema::create('promo_code_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_codes_id')->constrained('promo_codes')->onDelete('cascade');
            $table->foreignId('customers_id')->constrained('customers')->onDelete('cascade');
            $table->integer('count')->default(0);
            $table->timestamps();
            $table->unique(['promo_codes_id', 'customers_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_code_usages');
    }
};
