<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jadwal_id');
            $table->integer('location_id');
            $table->integer('user_id');
            $table->integer('status');
            $table->date('tanggal_masuk');
            $table->date('tanggal_pulang')->nullable();
            $table->time('jam_masuk');
            $table->time('jam_pulang')->nullable();
            $table->string('latitude_masuk')->nullable();
            $table->string('longitude_masuk')->nullable();
            $table->string('latitude_pulang')->nullable();
            $table->string('longitude_pulang')->nullable();
            $table->string('keterangan_masuk')->nullable();
            $table->string('keterangan_pulang')->nullable();
            $table->string('alasan_masuk')->nullable();
            $table->string('alasan_pulang')->nullable();
            $table->integer('host_id')->nullable();
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
        Schema::dropIfExists('absensis');
    }
}
