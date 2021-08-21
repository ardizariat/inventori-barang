<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pb_detail', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('pb_id');
            $table->uuid('produk_id');
            $table->bigInteger('qty');
            $table->bigInteger('harga');
            $table->bigInteger('subtotal');

            $table->foreign('pb_id')->references('id')->on('pb')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pb_detail');
    }
}
