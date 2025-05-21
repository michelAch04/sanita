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
            // Foreign key to products table
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('unit_price');
            $table->integer('quantity');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_details');
    }
}
