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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('type', ['b2b', 'b2c'])->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->date('DOB')->nullable();
            $table->string('mobile')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('email')->unique()->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->tinyInteger('verified')->default(0);
            $table->string('password');
            $table->string('token')->nullable();
            $table->tinyInteger('locked')->default(0);
            $table->tinyInteger('cancelled')->default(0);
            $table->string('device_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
