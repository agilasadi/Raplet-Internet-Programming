<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreatePostsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('posts', function (Blueprint $table)
			{
				$table->bigIncrements('id');
				$table->string('content');
				$table->bigInteger('user_id')->default('1');
				$table->bigInteger('category_id')->default('0');
				$table->bigInteger('entrycount')->default('0');
				$table->bigInteger('likecount')->default('0');
				$table->bigInteger('sharecount')->default('0');
				$table->bigInteger('reportcount')->default('0');
				$table->integer('is_featured')->default('1');

				$table->bigInteger('parent_id')->nullable()->default(null)
					->comment('if this content is a main content it has no parent id, but by default user can not enter top level of comment');
				$table->string('post_rank')->nullable()->default("regular")
					->comment("it defines if this content is a Top level of post or sub level of post.");
				$table->integer('lang_id')->default('0')
					->comment('It defies what is the main language of this post, if it is null than there is no language defined');

				$table->string('slug');
				$table->integer('type')->default("0");

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
			Schema::dropIfExists('posts');
		}
	}
