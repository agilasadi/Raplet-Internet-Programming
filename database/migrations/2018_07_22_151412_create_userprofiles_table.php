<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('lang_id')->default('1');
            $table->string('location')->nullable()->default(null);
            $table->integer('role_id')->default('4');
            $table->bigInteger('reputation')->default('0');
            $table->string('userImg')->default('profile.jpg');
            $table->string('slug');
            $table->string('name');
            $table->text('bio');
            $table->integer('notification_count')->nullable()->default("0");
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
        Schema::dropIfExists('userprofiles');
    }
}
