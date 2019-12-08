<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('carousel_title');
            $table->string('image');
            $table->string('image_alt');
            $table->string('top_text')->nullable();
            $table->string('top_url')->nullable();
            $table->string('top_fontsize')->nullable();
            $table->string('middle_text')->nullable();
            $table->string('middle_url')->nullable();
            $table->string('middle_fontsize')->nullable();
            $table->string('bottom_text')->nullable();
            $table->string('bottom_url')->nullable();
            $table->string('bottom_fontsize')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('carousel');
    }
}
