<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topcategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('specialcode_tc')->nullable();
            $table->string('name_tc');
            $table->string('name_tc_web')->nullable();
            $table->string('slug')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo3')->nullable();
            $table->string('short_description')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('description')->nullable();
            $table->boolean('menu')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('topcategories');
    }
}
