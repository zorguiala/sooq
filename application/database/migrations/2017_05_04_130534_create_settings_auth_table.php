<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('need_activation')->default(false);
            $table->string('activation_type')->default('admin');
            $table->integer('activation_expired_time')->default(60);
            $table->integer('max_warnings')->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_auth');
    }
}
