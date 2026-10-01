<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userid');
            $table->string('lat_masuk')->nullable();
            $table->string('lng_masuk')->nullable();
            $table->string('lat_pulang')->nullable();
            $table->string('lng_pulang')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->datetime('waktu_masuk');
            $table->datetime('waktu_pulang')->nullable();
            $table->string('keterangan_masuk')->nullable();
            $table->string('keterangan_pulang')->nullable();
            $table->string('catatan_admin_masuk')->nullable();
            $table->string('catatan_admin_pulang')->nullable();
            $table->integer('host_masuk');
            $table->integer('host_pulang');


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
        Schema::dropIfExists('bts');
    }
}
