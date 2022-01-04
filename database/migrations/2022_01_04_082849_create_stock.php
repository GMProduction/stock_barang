<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barang_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->integer('qty')->default(0);
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->foreign('cabang_id')->references('id')->on('cabangs');
            $table->timestamps();
        });

        Schema::table('barang_masuk', function (Blueprint $table){
            $table->text('keterangan')->after('qty')->nullable();
        });

        Schema::table('barang_keluar', function (Blueprint $table){
            $table->text('keterangan')->after('qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
