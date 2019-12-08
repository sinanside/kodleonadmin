<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('gsm');
            $table->string('fax');
            $table->string('email')->unique();
            $table->string('map');
            $table->string('host');
            $table->integer('port');
            $table->string('smtpsecure');
            $table->string('username');
            $table->string('password');
            $table->string('gmail');
            $table->string('gisim');
            $table->string('subject');
            $table->boolean('active');
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
        Schema::dropIfExists('contacts');
    }
}
