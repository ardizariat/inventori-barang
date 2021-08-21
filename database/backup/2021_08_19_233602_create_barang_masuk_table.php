<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('po_id');
            $table->uuid('produk_id');
            $table->unsignedBigInteger('penerima');
            $table->bigInteger('qty');
            $table->enum('status_barang', ['diterima', 'belum diterima'])->default('belum diterima');
            $table->timestamps();

            $table->foreign('po_id')->references('id')->on('po')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('penerima')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('barang_masuk');
    }
}
