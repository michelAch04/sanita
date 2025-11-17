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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('street');
            $table->string('building');
            $table->string('floor')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_default')->default(false);
            $table->tinyInteger('cancelled')->default(0);
            $table->foreignId('governorates_id')->constrained('governorates')->onDelete('cascade');
            $table->foreignId('districts_id')->constrained('districts')->onDelete('cascade');
            $table->foreignId('cities_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('customers_id')->constrained('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
