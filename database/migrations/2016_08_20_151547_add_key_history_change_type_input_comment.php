<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeyHistoryChangeTypeInputComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('key_histories', function (Blueprint $table) {
            $table->text('input_data')->change();
            $table->text('comment')->change();
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
