<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_payments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('payment_id');
            $table->string('transaction_id');
            $table->string('payment_method')->default('paypal');
            $table->string('payment_type')->default('account');
            $table->string('payment_amount')->nullable();
            $table->string('payment_currency')->default('usd');
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
        Schema::drop('notifications_payments');
    }
}
