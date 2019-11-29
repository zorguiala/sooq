<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_share', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->boolean('fb_active')->default(false);
            $table->boolean('tw_active')->default(false);
            $table->text('tw_consumer_key')->nullable();
            $table->text('tw_consumer_secret')->nullable();
            $table->text('tw_access_token')->nullable();
            $table->text('tw_access_token_secret')->nullable();
            $table->text('fb_app_id')->nullable();
            $table->text('fb_app_secret')->nullable();
            $table->text('fb_access_token')->nullable();
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
        Schema::drop('auto_share');
    }
}
