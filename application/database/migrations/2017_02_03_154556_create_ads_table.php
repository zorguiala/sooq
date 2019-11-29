<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function(Blueprint $table){
            $table->increments('id');
            $table->string('ad_id')->unique();
            $table->integer('user_id');
            $table->integer('category');
            $table->text('photos');
            $table->text('thumbnails');
            $table->integer('photos_number')->default(0);
            $table->boolean('negotiable')->default(true);
            $table->boolean('is_used')->default(true);
            $table->string('title');
            $table->text('description');
            $table->string('country', 2)->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->string('price')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_trashed')->default(false);
            $table->boolean('trashed_by_admin')->default(false);
            $table->timestamp('deleted_at')->nullable();
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
        Schema::drop('ads');
    }
}
