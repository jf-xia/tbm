<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasktypeEavsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasktype_eavs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tasktype_id');
            $table->string('code')->unique();
            $table->string('frontend_label');
            $table->string('frontend_input');
            $table->integer('frontend_size');
            $table->integer('is_required');
            $table->integer('is_unique');
            $table->string('option');
            $table->integer('user_id');
            $table->string('note');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasktype_eavs');
    }
}
