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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->nullable()->index();
            $table->unsignedBigInteger('pages_id')->nullable()->index();
            $table->tinyInteger('add')->default(0);
            $table->tinyInteger('edit')->default(0);
            $table->tinyInteger('delete')->default(0);
            $table->tinyInteger('view')->default(0);
            $table->tinyInteger('excel')->default(0);
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pages_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
