<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeeperTranslateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keeper_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->string('keeper_id');
            $table->string('image')->default('0');
            $table->string('link_text')->default('0');
            $table->string('link_url')->default('0');
            $table->integer('lang_id');
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
        Schema::dropIfExists('keeper_translate');
    }
}
