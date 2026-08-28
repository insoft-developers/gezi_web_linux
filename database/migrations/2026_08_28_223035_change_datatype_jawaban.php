<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDatatypeJawaban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_soal_details', function (Blueprint $table) {
            $table->longText('jawaban_a')->change();
            $table->longText('jawaban_b')->change();
            $table->longText('jawaban_c')->change();
            $table->longText('jawaban_d')->change();
            $table->longText('jawaban_e')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_soal_details', function (Blueprint $table) {
            //
        });
    }
}
