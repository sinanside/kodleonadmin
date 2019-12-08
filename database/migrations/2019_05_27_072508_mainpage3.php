<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mainpage3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagecreators', function($table) {
            $table->string('picture1');
            $table->string('picture1_alt');
            $table->string('picture2');
            $table->string('picture2_alt');
            $table->string('picture3');
            $table->string('picture3_alt');
            $table->string('picture4');
            $table->string('picture4_alt');
            $table->string('picture5');
            $table->string('picture5_alt');
            $table->string('picture6');
            $table->string('picture6_alt');
            $table->string('picture7');
            $table->string('picture7_alt');
            $table->string('picture8');
            $table->string('picture8_alt');
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
            $table->dropColumn('picture1');
            $table->dropColumn('picture1_alt');
            $table->dropColumn('picture2');
            $table->dropColumn('picture2_alt');
            $table->dropColumn('picture3');
            $table->dropColumn('picture3_alt');
            $table->dropColumn('picture4');
            $table->dropColumn('picture4_alt');
            $table->dropColumn('picture5');
            $table->dropColumn('picture5_alt');
            $table->dropColumn('picture6');
            $table->dropColumn('picture6_alt');
            $table->dropColumn('picture7');
            $table->dropColumn('picture7_alt');
            $table->dropColumn('picture8');
            $table->dropColumn('picture8_alt');
        });
    }
}
