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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->integer('cat_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('short_content')->nullable();
            $table->text('content')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo1_alt')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo2_alt')->nullable();
            $table->string('photo3')->nullable();
            $table->string('photo3_alt')->nullable();
            $table->integer('queue')->unsigned()->nullable();
            $table->boolean('mainpage')->nullable();
            $table->boolean('active')->nullable();
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
