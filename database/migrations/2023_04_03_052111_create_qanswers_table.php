<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qanswers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_guru');
            $table->integer('id_soal');
            $table->string('jawaban');
            $table->string('jawaban_gambar');
            $table->integer('status');
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
        Schema::dropIfExists('qanswers');
    }
}
