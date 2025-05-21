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
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->string('promocode')->nullable();
            $table->boolean('purchased')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
