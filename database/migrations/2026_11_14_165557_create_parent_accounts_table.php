
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('parent_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('phone', 30);
            $table->string('password');

            $table->unsignedInteger('school_id');

            $table->boolean('is_active')->default(true);
            $table->boolean('must_change_password')->default(true);

            $table->timestamps();

            $table->unique(
                ['school_id', 'phone'],
                'parent_school_phone_unique'
            );

            $table->index('school_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('parent_accounts');
    }
}
