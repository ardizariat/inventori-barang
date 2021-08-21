<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_detail', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('pr_id');
            $table->uuid('produk_id');
            $table->bigInteger('qty');
            $table->bigInteger('harga');
            $table->bigInteger('subtotal');

            $table->foreign('pr_id')->references('id')->on('pr')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pr_detail');
    }
}
