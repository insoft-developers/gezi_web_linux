
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentStudentTable extends Migration
{
    public function up()
    {
        Schema::create('parent_student', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('student_id');

            $table->string('relationship', 20);

            $table->timestamps();

            $table->unique(
                ['parent_id', 'student_id'],
                'parent_student_unique'
            );

            $table->foreign('parent_id')
                ->references('id')
                ->on('parent_accounts')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('parent_student');
    }
}
