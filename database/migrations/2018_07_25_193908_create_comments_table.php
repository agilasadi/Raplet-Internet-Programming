<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');
            $table->string('slug');
            $table->bigInteger('user_id');
            $table->bigInteger('post_id');
            $table->integer('lang_id')->default('0');
            $table->bigInteger('likecount')->default('0');
            $table->bigInteger('dislikecount')->default('0');
            $table->integer('sharecount')->default('0');
            $table->integer('reportcount')->default('0');
            $table->integer('checked')->default('0');
            $table->integer('protected')->default('0');
            $table->integer('is_featured')->default('0');
            $table->bigInteger('anonym')->default('1');

            $table->softDeletes();
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
        Schema::dropIfExists('comments');
    }
}
