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
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->date('DOB')->nullable()->after('last_name');
            $table->string('mobile')->nullable()->after('DOB');
            $table->string('email')->unique()->after('mobile');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('email');
            $table->timestamp('email_verified_at')->nullable()->after('gender');
            $table->string('password');
            $table->string('token')->nullable();
            $table->boolean('locked')->default(false)->after('token');
            $table->boolean('cancelled')->default(false)->after('locked');
            $table->string('device_id')->nullable()->after('cancelled');
            $table->softDeletes(); // adds deleted_at
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
