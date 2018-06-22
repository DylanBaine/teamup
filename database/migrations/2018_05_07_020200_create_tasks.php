<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();

            $table->string('name');
            $table->longText('description');
            $table->integer('column_id')->nullable();
            $table->integer('percent_finished')->nullable();
            $table->string('icon')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
