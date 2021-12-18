<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('nama');
            $table->string('satuan');
            $table->integer('harga')->default(0);
            $table->text('gambar')->nullable();
            $table->bigInteger('jenis_barang_id')->unsigned();
            $table->foreign('jenis_barang_id')->references('id')->on('jenis_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
