<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carts_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('products_id')->constrained()->onDelete('cascade');
            $table->decimal('unit_price');
            $table->decimal('shelf_price');
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('extended_price');
            $table->integer('quantity_ea');
            $table->string('UOM');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_details');
    }
}
