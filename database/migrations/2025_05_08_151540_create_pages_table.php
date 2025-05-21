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
        Schema::create('pages', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name of the page
            $table->string('url'); // URL of the page
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->integer('order')->default(0);
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
