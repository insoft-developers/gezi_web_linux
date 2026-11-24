<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidToAbsensisAndBtsTables extends Migration
{
    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->unique('absensis_uuid_unique');
        });

        Schema::table('bts', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->unique('bts_uuid_unique');

            $table->integer('host_pulang')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropUnique('absensis_uuid_unique');
            $table->dropColumn('uuid');
        });

        Schema::table('bts', function (Blueprint $table) {
            $table->dropUnique('bts_uuid_unique');
            $table->dropColumn('uuid');

            $table->integer('host_pulang')->nullable(false)->change();
        });
    }
}