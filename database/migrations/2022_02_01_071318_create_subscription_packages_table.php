<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->string('productId')->nullable();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->string('price_amount_micros')->nullable();
            $table->string('price_currency_code')->nullable();
            $table->string('description')->nullable();
            $table->string('subscriptionPeriod')->nullable();
            $table->string('skuDetailsToken')->nullable();
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
        Schema::dropIfExists('subscription_packages');
    }
}
