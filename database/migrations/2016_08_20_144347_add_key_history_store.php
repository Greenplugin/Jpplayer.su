<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeyHistoryStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('key_histories', function (Blueprint $table) {
            $table->text('user_ip');
            $table->integer('user_id');
            $table->integer('user_type');
            $table->integer('device_type');
            $table->integer('input_data');
            $table->integer('result');
            $table->integer('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('key_histories', function (Blueprint $table) {
            //
        });
    }
}
