<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsGeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_general', function(Blueprint $table){
            $table->increments('id');
            $table->string('title')->default('EVEREST');
            $table->string('description')->default('Classifieds PHP Script');
            $table->string('logo')->default('logo.png');
            $table->string('favicon')->default('favicon.png');
            $table->string('language', 2)->default('en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_general');
    }
}
