<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produk_id')->unsigned();
            $table->integer('cart_id')->unsigned();
            $table->string('status_pesanan');
            $table->double('qty', 12, 2)->default(0);
            $table->double('harga', 12, 2)->default(0);
            $table->double('diskon', 12, 2)->default(0);
            $table->double('subtotal', 12, 2)->default(0);
            $table->foreign('cart_id')->references('id')->on('cart');
            $table->foreign('produk_id')->references('id')->on('produk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_detail');
    }
};
