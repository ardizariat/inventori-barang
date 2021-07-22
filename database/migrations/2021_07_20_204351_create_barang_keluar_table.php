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
            $table->bigInteger('jumlah');
            $table->string('penerima')->nullable();
            $table->string('pemberi')->nullable();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade')->onUpdate('cascade');
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
