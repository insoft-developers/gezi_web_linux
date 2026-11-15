<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPdfActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_pdf_activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('student_id');

            $table->unsignedBigInteger('pdf_id');

            $table->unsignedInteger('open_count')->default(0);

            $table->timestamp('first_opened_at')->nullable();

            $table->timestamp('last_opened_at')->nullable();

            $table->timestamps();

            $table->unique([
                'student_id',
                'pdf_id'
            ], 'student_pdf_unique');

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
        Schema::dropIfExists('student_pdf_activities');
    }
}
