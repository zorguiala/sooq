<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsMembershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_membership', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency')->default('USD');
            $table->string('one_month_price')->default('17.00');
            $table->string('six_months_price')->default('99.00');
            $table->string('one_year_price')->default('129.00');
            $table->string('two_years_price')->default('179.99');
            $table->string('three_years_price')->default('219.00');
            $table->string('ad_1_month_price')->default('2.99');
            $table->string('ad_3_months_price')->default('7.00');
            $table->string('ad_6_months_price')->default('12.99');
            $table->string('ad_12_months_price')->default('22.99');
            $table->string('ad_24_months_price')->default('39.00');
            $table->string('ad_36_months_price')->default('69.99');
            $table->integer('free_ads_per_day')->default(3);
            $table->integer('pro_ads_per_day')->default(10);
            $table->string('free_ad_life')->default('month');
            $table->string('pro_ad_life')->default('year');
            $table->integer('free_ad_images')->default(4);
            $table->integer('pro_ad_images')->default(12);
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
        Schema::drop('settings_membership');
    }
}
