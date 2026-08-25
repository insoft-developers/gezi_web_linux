<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankSoalAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_soal_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_session');
            $table->integer('id_user');
            $table->integer('id_soal');
            $table->string('no_soal');
            $table->string('jawaban_user');
            $table->string('waktu_selesai');
            $table->string('status_jawaban');
            $table->string('hasil_jawaban');
            $table->integer('score');
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
        Schema::dropIfExists('bank_soal_answers');
    }
}
