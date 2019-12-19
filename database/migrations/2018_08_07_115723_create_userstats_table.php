<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserstatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userstats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('entrycount')->default('0');
            $table->integer('headercount')->default('0');
            $table->integer('likecount')->default('0');
            $table->integer('likercount')->default('0');
            $table->integer('voteupcount')->default('0');
            $table->integer('votedown')->default('0');
            $table->integer('reporting')->default('0');
            $table->integer('reported')->default('0');
            $table->integer('secretpoint')->default('0');
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
        Schema::dropIfExists('userstats');
    }
}
