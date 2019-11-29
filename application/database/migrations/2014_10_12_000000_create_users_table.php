<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 60)->nullable();
            $table->string('avatar')->default('avatar.png');
            $table->boolean('gender')->default(false);
            $table->string('country_code', 2);
            $table->integer('state');
            $table->integer('city');
            $table->string('phone', 60)->nullable();
            $table->boolean('phone_hidden')->default(false);
            $table->boolean('account_type')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('has_store')->default(false);
            $table->timestamp('store_ends_at')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('last_login_ip', 50)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
