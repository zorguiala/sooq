<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('ad_id');
            $table->string('pack')->default(3);
            $table->string('brand')->default('paypal');
            $table->string('transaction_id');
            $table->string('card_number')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('cvv')->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->string('amount');
            $table->string('currency')->default('usd');
            $table->boolean('is_accepted')->nullable();
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
        Schema::drop('ads_payments');
    }
}
