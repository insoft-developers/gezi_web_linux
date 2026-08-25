<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTobkVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tobk_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_kategori');
            $table->string('judul');
            $table->string('link_video');
            $table->integer('is_active');
            $table->integer('is_watched');
            $table->integer('is_liked');
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
        Schema::dropIfExists('tobk_videos');
    }
}
