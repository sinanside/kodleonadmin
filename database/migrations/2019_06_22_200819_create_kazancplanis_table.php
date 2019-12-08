<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKazancplanisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kazancplanis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->text('short_content1')->nullable();
            $table->text('short_content2')->nullable();
            $table->text('short_content3')->nullable();
            $table->text('content')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo1_alt')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo2_alt')->nullable();
            $table->string('photo3')->nullable();
            $table->string('photo3_alt')->nullable();
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
        Schema::dropIfExists('kazancplanis');
    }
}
