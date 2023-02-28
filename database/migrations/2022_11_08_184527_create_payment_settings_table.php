<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->text("paypal_client_id")->nullable();
            $table->text("paypal_secret_key")->nullable();
            $table->text("stripe_publishable_key")->nullable();
            $table->text("stripe_secret_key")->nullable();
            $table->text("wyre_client_id")->nullable();
            $table->text("wyre_secret_key")->nullable();
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
        Schema::dropIfExists('payment_settings');
    }
}
