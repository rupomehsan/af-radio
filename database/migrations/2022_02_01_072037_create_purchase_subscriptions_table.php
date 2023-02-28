<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('subscription_package_id')->nullable();
            $table->string('orderId')->nullable();
            $table->string('packageName')->nullable();
            $table->string('productId')->nullable();
            $table->string('purchaseTime')->nullable();
            $table->string('purchaseState')->nullable();
            $table->string('purchaseToken')->nullable();
            $table->string('quantity')->nullable();
            $table->boolean('autoRenewing')->nullable();
            $table->boolean('acknowledged')->nullable();
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
        Schema::dropIfExists('purchase_subscriptions');
    }
}
