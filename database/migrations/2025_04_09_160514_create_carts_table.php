<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customers_id')->constrained('customers')->onDelete('cascade');
            $table->decimal('total_amount'); //with vat 
            $table->decimal('total_amount_after_discount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('subtotal_amount'); //without vat 
            $table->decimal('tax_amount'); // tax amount
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
