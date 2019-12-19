<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeepersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keepers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->string('image')->default('0');
            $table->string('link_text')->default('0');
            $table->string('link_url')->default('0');
            $table->string('type')->default('1');
            $table->string('status')->default('1');
            $table->string('lang_short')->default('en');
            $table->string('user_type')->default('web');
            $table->dateTime('expire');
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
        Schema::dropIfExists('keepers');
    }
}
