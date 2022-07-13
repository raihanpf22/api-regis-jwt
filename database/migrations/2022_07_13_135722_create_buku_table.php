<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->string('kode_buku')->primary_key();
            $table->string('id_kategori')->unique();
            $table->string('judlu_buku');
            $table->string('penulis_buku');
            $table->string('penerbit_buku');
            $table->string('tahun_terbit');
            $table->integer('stok_buku');
            $table->string('gambar_buku');
            $table->string('url_gambar_buku');
            $table->string('status_buku');
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
        Schema::dropIfExists('buku');
    }
}
