<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position')->default(9999);

            // Multilingual name
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('name_ku');

            $table->string('extension')->nullable();
            $table->tinyInteger('hidden')->default(0);
            $table->tinyInteger('cancelled')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
