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
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nsm_instansi');
            $table->string('npsn_instansi');
            $table->string('nama_instansi');
            $table->string('email_instansi')->nullable();
            $table->text('alamat_instansi')->nullable();
            $table->string('logo_instansi')->nullable();
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->timestamps();

            $table->foreign('guru_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instansi');
    }
};
