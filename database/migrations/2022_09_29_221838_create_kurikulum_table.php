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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable();
            $table->string('nama_kurikulum');
            $table->integer('is_active')->default(0);
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
        Schema::dropIfExists('kurikulum');
    }
};
