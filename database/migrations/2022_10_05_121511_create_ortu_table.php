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
        Schema::create('ortu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable()->unique();
            $table->string('tmp_lahir_ayah')->nullable();
            $table->date('tgl_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('gaji_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable()->unique();
            $table->string('tmp_lahir_ibu')->nullable();
            $table->date('tgl_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('gaji_ibu')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('alamat_ortu')->nullable();
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
        Schema::dropIfExists('ortu');
    }
};
