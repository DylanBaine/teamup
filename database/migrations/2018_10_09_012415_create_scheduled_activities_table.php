<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedulable_id');
            $table->string('schedulable_type');
            $table->string('type')->nullable();
            $table->string('week')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
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
        Schema::dropIfExists('scheduled_activities');
    }
}
