<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contactables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->integer('contactable_id');
            $table->string('contactable_type');
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
        Schema::table('contactables', function (Blueprint $table) {
            //
        });
    }
}
