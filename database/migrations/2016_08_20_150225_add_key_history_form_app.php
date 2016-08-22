<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeyHistoryFormApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('key_histories', function (Blueprint $table) {
            $table->text('app_type');
            $table->removeColumn('user_type');
            $table->string('input_data')->change();
            $table->string('result')->change();
            $table->string('comment')->change();
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
