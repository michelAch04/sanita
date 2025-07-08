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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->dateTime('start_date');
            $table->datetime('end_date');
            $table->enum('type', ['percentage']);
            $table->decimal('value');
            $table->integer('max_uses');
            $table->integer('used_count');
            $table->integer('max_uses_per_user');
            $table->decimal('min_order_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
