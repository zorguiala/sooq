<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMailboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_mailbox', function(Blueprint $table){
            $table->increments('id');
            $table->string('ad_id');
            $table->string('msg_from');
            $table->string('msg_to');
            $table->string('email');
            $table->boolean('show_email')->default(false);
            $table->string('phone')->nullable();
            $table->boolean('show_phone')->default(false);
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_read')->default(false);
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
        //
    }
}
