<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_security', function (Blueprint $table) {
            $table->increments('id');
            $table->text('blacklist_username')->nullable();
            $table->boolean('auto_approve_ads')->default(true);
            $table->boolean('auto_approve_comments')->default(true);
            $table->boolean('recaptcha')->default(false);
            $table->integer('max_attempts')->default(3);
            $table->integer('unlock_time')->default(1800);
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
        Schema::drop('settings_security');
    }
}
