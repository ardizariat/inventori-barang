<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_detail', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('po_id');
            $table->uuid('produk_id');
            $table->integer('qty');
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('subtotal')->nullable();

            $table->foreign('po_id')->references('id')->on('po')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('po_detail');
    }
}
