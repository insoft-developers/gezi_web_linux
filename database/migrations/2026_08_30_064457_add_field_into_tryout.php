<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIntoTryout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('try_outs', function (Blueprint $table) {
            $table->tinyInteger('is_random_question')->after('urutan')->default(0);
            $table->tinyInteger('is_random_answer')->after('is_random_question')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('try_outs', function (Blueprint $table) {
            //
        });
    }
}
