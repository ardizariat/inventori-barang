<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('purchase_order_id');
            $table->uuid('produk_id');
            $table->integer('qty');
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('subtotal')->nullable();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_order')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('restrict')->onUpdate('cascade');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_detail');
    }
}
