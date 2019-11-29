<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('payment_id');
            $table->string('balance_transaction');
            $table->string('card_number');
            $table->integer('exp_month');
            $table->integer('exp_year');
            $table->integer('last_four');
            $table->string('brand')->nullable();
            $table->string('country')->nullable();
            $table->string('amount');
            $table->string('currency')->default('usd');
            $table->boolean('is_accepted')->nullable()->default(NULL);
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
        Schema::drop('card_payments');
    }
}
