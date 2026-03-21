<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pos_locations', function (Blueprint $table) {
            // Drop the FK constraint first so we can make cities_id nullable
            $table->dropForeign(['cities_id']);

            $table->unsignedBigInteger('cities_id')->nullable()->change();
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();

            // Re-add FK allowing null (set null on delete)
            $table->foreign('cities_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pos_locations', function (Blueprint $table) {
            $table->dropForeign(['cities_id']);

            $table->unsignedBigInteger('cities_id')->nullable(false)->change();
            $table->decimal('latitude', 10, 7)->nullable(false)->change();
            $table->decimal('longitude', 10, 7)->nullable(false)->change();

            $table->foreign('cities_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }
};
