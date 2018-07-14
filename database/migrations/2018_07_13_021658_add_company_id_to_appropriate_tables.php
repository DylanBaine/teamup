<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToAppropriateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('types', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('permission_modes', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('edits', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
