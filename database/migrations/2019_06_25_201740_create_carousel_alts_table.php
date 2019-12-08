<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselAltsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel_alts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('carousel_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('color')->nullable();
            $table->string('delay')->nullable();
            $table->integer('x1')->nullable();
            $table->integer('x2')->nullable();
            $table->integer('x3')->nullable();
            $table->integer('x4')->nullable();
            $table->integer('y1')->nullable();
            $table->integer('y2')->nullable();
            $table->integer('y3')->nullable();
            $table->integer('y4')->nullable();
            $table->integer('fontsize1')->nullable();
            $table->integer('fontsize2')->nullable();
            $table->integer('fontsize3')->nullable();
            $table->integer('fontsize4')->nullable();
            $table->integer('lineheight1')->nullable();
            $table->integer('lineheight2')->nullable();
            $table->integer('lineheight3')->nullable();
            $table->integer('lineheight4')->nullable();
            $table->integer('fontweight1')->nullable();
            $table->integer('fontweight2')->nullable();
            $table->integer('fontweight3')->nullable();
            $table->integer('fontweight4')->nullable();
            $table->string('visibility1')->nullable();
            $table->string('visibility2')->nullable();
            $table->string('visibility3')->nullable();
            $table->string('visibility4')->nullable();
            $table->integer('queue')->nullable();
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
        Schema::dropIfExists('carousel_alts');
    }
}
