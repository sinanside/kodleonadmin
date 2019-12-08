<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOurteamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ourteams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->integer('type')->unsigned()->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->text('description3')->nullable();
            $table->text('description4')->nullable();
            $table->text('short_content')->nullable();
            $table->text('content')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo1_alt')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo2_alt')->nullable();
            $table->string('photo3')->nullable();
            $table->string('photo3_alt')->nullable();
            $table->string('photo4')->nullable();
            $table->string('photo4_alt')->nullable();
            $table->integer('queue')->unsigned()->nullable();
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
        Schema::dropIfExists('ourteams');
    }
}
