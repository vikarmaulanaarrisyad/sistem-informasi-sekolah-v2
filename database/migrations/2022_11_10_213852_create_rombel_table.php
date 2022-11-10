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
        Schema::create('rombel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable();
            $table->unsignedBigInteger('kurikulum_id')->nullable();
            $table->string('nama_rombel');
            $table->integer('tingkat_rombel')->default(0);
            $table->integer('jumlah_siswa')->default(0);
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
        Schema::dropIfExists('rombel');
    }
};
