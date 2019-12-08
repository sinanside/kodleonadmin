<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mainpage2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagecreators', function($table) {
            $table->string('short_description1');
            $table->string('short_description2');
            $table->string('short_description3');
            $table->string('short_description4');
            $table->string('short_description5');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagecreators', function($table) {
            $table->dropColumn('short_description1');
            $table->dropColumn('short_description2');
            $table->dropColumn('short_description3');
            $table->dropColumn('short_description4');
            $table->dropColumn('short_description5');

        });
    }
}
