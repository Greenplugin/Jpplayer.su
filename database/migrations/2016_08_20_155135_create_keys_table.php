<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('user_ip');
            $table->integer('user_id');
            $table->text('device_type');
            $table->text('result');
            $table->text('app_type');
            $table->text('input_data');
            $table->text('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('keys');
    }
}
