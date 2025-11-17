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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customers_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('distributors_id')->constrained('distributors')->onDelete('cascade');
            $table->foreignId('addresses_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('statuses_id')->constrained('statuses')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('total_amount_after_discount', 10, 2)->default(0);
            $table->decimal('subtotal_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->string('promocode')->nullable();
            $table->tinyInteger('cancelled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
