<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function(Blueprint $table){
            $table->increments('id');
            $table->string('ad_id');
            $table->integer('owner');
            $table->string('ip_address')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('browserName')->nullable();
            $table->string('browserVersion')->nullable();
            $table->string('platformName')->nullable();
            $table->string('platformVersion')->nullable();
            $table->string('deviceName')->nullable();
            $table->integer('isPhone')->default(0);
            $table->integer('isDesktop')->default(1);
            $table->integer('isRobot')->default(0);
            $table->string('robotName')->nullable();
            $table->string('referrer')->nullable();
            $table->string('referrer_keyword')->nullable();
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
        Schema::drop('stats');
    }
}
