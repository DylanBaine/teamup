<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('column_id');
            $table->integer('task_id');
            $table->integer('user_id');
            $table->integer('duration_in_seconds');
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
        Schema::dropIfExists('progress_changes');
    }
}
