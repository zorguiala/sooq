<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsAdsAcceptedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_ads_accepted', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('ad_id');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications_ads_accepted');
    }
}
