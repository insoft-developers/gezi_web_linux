<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OptimizeDatatableIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->index(
                ['user_id', 'id_quiz', 'id'],
                'idx_quiz_sessions_user_quiz_id'
            );
        });

        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->index(
                ['id_quiz'],
                'idx_quiz_answers_session'
            );
        });

        Schema::table('bank_soal_sessions', function (Blueprint $table) {
            $table->index(
                ['id_user', 'id_bank_soal', 'id'],
                'idx_bank_sessions_user_bank_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->dropIndex('idx_quiz_sessions_user_quiz_id');
        });

        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropIndex('idx_quiz_answers_session');
        });

        Schema::table('bank_soal_sessions', function (Blueprint $table) {
            $table->dropIndex('idx_bank_sessions_user_bank_id');
        });
    }
}
