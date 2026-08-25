<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->integer('id_kelas');
            $table->integer('id_kategori');
            $table->integer('is_active');
            $table->integer('is_skipped');
            $table->integer('is_repeated');
            $table->integer('target_score');
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
        Schema::dropIfExists('bank_soals');
    }
}
