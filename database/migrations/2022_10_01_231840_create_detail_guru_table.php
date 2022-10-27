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
        Schema::create('detail_guru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->unsignedBigInteger('pendidikan_id')->nullable();
            $table->unsignedBigInteger('agama_id')->nullable();
            $table->string('tempat_lahir_guru');
            $table->date('tgl_lahir_guru');
            $table->text('alamat_guru');
            $table->date('tmt_guru');
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
        Schema::dropIfExists('detail_guru');
    }
};
