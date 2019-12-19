<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeeperUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keeper_user', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->defualt("0");
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('keeper_id')->unsigned();
            $table->foreign('keeper_id')->references('id')->on('keepers');

            $table->string('user_ip')->defualt("0");
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
        Schema::dropIfExists('keeper_user');
    }
}
