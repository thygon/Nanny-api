<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myprofiles', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dob');
            $table->text('shortmsg');
            $table->string('age');
            $table->string('level');
            $table->string('dpic');
            $table->string('goodconduct');
            $table->string('address');
            $table->integer('user_id')->unsigned();
            $table->integer('amount')->default(0);
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
        Schema::dropIfExists('myprofiles');
    }
}
