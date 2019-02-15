<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaulesScrum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nom');
        });

        Schema::create('user_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_team')->unsigned();
            $table->integer('id_user')->unsigned();

            $table->foreign('id_team')->references('id')->on('teams');
            $table->foreign('id_user')->references('id')->on('users');
        });

        Schema::create('projectes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nom');
            $table->text('descripcio');
            $table->integer('team')->unsigned();
            $table->integer('product_owner')->unsigned();
            $table->integer('scrum_master')->unsigned();

            $table->foreign('team')->references('id')->on('teams');
            $table->foreign('product_owner')->references('id')->on('users');
            $table->foreign('scrum_master')->references('id')->on('users');
        });

        Schema::create('sprints', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date("data_inici");
            $table->date("data_final");
            $table->integer('projecte')->unsigned();

            $table->foreign('projecte')->references('id')->on('projectes');
        });

        Schema::create('specs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('descripcio');
            $table->integer('hores')->nullable();
            $table->integer('dificultat')->nullable();
            $table->integer('sprint')->unsigned()->nullable();
            $table->integer('projecte')->unsigned();

            $table->foreign('projecte')->references('id')->on('projectes');
            $table->foreign('sprint')->references('id')->on('sprints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projectes');
        Schema::dropIfExists('user_teams');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('sprints');
        Schema::dropIfExists('specs');
    }
}
