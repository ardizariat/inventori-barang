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
            $table->uuid('pb_id')->nullable();
            $table->uuid('pr_id')->nullable();
            $table->unsignedBigInteger('penerima');
            $table->bigInteger('qty');
            $table->bigInteger('subtotal');
            $table->enum('jenis_permintaan', ['pb', 'pr'])->nullable();
            $table->enum('status', ['sudah dikeluarkan', 'belum dikeluarkan'])->default('belum dikeluarkan');
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pb_id')->references('id')->on('pb')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pr_id')->references('id')->on('pr')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('barang_keluar');
    }
}
