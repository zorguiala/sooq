<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_seo', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->text('google_analytics')->nullable();
            $table->boolean('is_sitemap')->default(false);
            $table->text('header_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_seo');
    }
}
