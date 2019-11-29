<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsWatermarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_watermark', function(Blueprint $table){
            $table->increments('id');
            $table->string('watermark')->default('watermark.png');
            $table->string('position')->default('center');
            $table->integer('opacity')->default(50);
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_watermark');
    }
}
