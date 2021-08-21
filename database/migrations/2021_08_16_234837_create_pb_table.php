<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pb', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('no_dokumen');
            $table->unsignedBigInteger('pemohon');
            $table->bigInteger('total_item');
            $table->bigInteger('total_harga');
            $table->text('keterangan')->nullable();
            $table->enum('sect_head', ['rejected', 'approved', 'on process'])->default('on process');
            $table->date('tgl_approve_sect')->nullable();
            $table->enum('dept_head', ['rejected', 'approved', 'on process'])->default('on process');
            $table->date('tgl_approve_dept')->nullable();
            $table->enum('status', ['sudah diterima', 'belum diterima'])->default('belum diterima');
            $table->timestamps();

            $table->foreign('pemohon')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('pb');
    }
}
