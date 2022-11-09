<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_ruang_id');
            $table->string('nama_ruangan');
            $table->tinyInteger('penggunaan_ruangan');
            $table->date('tahun_dibangun');
            $table->string('panjang_ruangan');
            $table->string('lebar_ruangan');
            $table->integer('kapasitas_ruangan')->default(0);
            $table->string('foto_ruangan')->nullable()->default('default.jpg');
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
        Schema::dropIfExists('ruangan');
    }
};
