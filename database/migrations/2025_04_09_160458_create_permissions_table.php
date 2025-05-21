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
            $table->tinyInteger('user_id')->unsigned()->index();
            $table->tinyInteger('add')->default(0);
            $table->tinyInteger('edit')->default(0);
            $table->tinyInteger('delete')->default(0);
            $table->tinyInteger('view')->default(0);
            $table->tinyInteger('excel')->default(0);
            $table->timestamps();
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
