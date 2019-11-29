<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function(Blueprint $table){
            $table->increments('id');
            $table->integer('owner_id');
            $table->string('username')->unique();
            $table->string('title');
            $table->string('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            $table->integer('category')->nullable();
            $table->string('logo')->default('store_logo');
            $table->string('country')->default('US');
            $table->integer('state');
            $table->integer('city');
            $table->string('address')->nullable();
            $table->string('fb_page')->nullable();
            $table->string('tw_page')->nullable();
            $table->string('yt_page')->nullable();
            $table->string('go_page')->nullable();
            $table->string('website')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamp('ends_at');
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
        Schema::drop('stores');
    }
}
