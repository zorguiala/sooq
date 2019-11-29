<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsGeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_geo', function(Blueprint $table){
            $table->increments('id');
            $table->boolean('is_international')->default(true);
            $table->integer('default_country')->default(231);
            $table->string('default_currency', 3)->default('USD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_geo');
    }
}
