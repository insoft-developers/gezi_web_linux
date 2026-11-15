<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentVideoActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_video_activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('student_id');

            $table->enum('video_type', [
                'bimbingan',
                'tobk'
            ]);

            $table->unsignedBigInteger('video_id');

            $table->unsignedInteger('watch_count')->default(0);

            $table->timestamp('last_watched_at')->nullable();

            $table->timestamps();

            $table->unique([
                'student_id',
                'video_type',
                'video_id'
            ], 'student_video_unique');

            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_video_activities');
    }
}
