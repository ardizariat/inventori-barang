<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('kategori_id');
            $table->uuid('gudang_id')->nullable();
            $table->uuid('supplier_id')->nullable();
            $table->string('kode');
            $table->string('nama_produk');
            $table->string('merek');
            $table->string('satuan');
            $table->integer('minimal_stok');
            $table->bigInteger('stok');
            $table->bigInteger('harga');
            $table->string('gambar')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif'])->default('tidak aktif');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('gudang_id')->references('id')->on('gudang')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('produk');
    }
}
