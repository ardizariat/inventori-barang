<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('produk_id');
            $table->uuid('pb_id');
            $table->unsignedBigInteger('pemberi');
            $table->unsignedBigInteger('penerima');
            $table->bigInteger('qty');
            $table->enum('status_barang', ['dikeluarkan', 'belum dikeluarkan'])->default('belum dikeluarkan');
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('pb_id')->references('id')->on('pb')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('pemberi')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('penerima')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('barang_keluar');
    }
}
