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
            $table->unsignedBigInteger('pages_id')->nullable()->index(); // Add this line
            $table->tinyInteger('add')->default(0);
            $table->tinyInteger('edit')->default(0);
            $table->tinyInteger('delete')->default(0);
            $table->tinyInteger('view')->default(0);
            $table->tinyInteger('excel')->default(0);
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('pages_id')->references('id')->on('pages')->onDelete('cascade');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
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
