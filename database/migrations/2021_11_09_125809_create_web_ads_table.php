<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_ads', function (Blueprint $table) {
            $table->id();
            $table->string('ad_type');
            $table->enum('status', ['on', 'off'])->nullable();
            $table->longText('ad_link')->nullable();
            $table->string('ad_title')->nullable();
            $table->integer('show_per_video_category')->nullable();
            $table->string('image')->nullable();

            $table->enum('disable_desktop', ['on', 'off'])->nullable();
            $table->string('desktop_adsense')->nullable();

            $table->enum('disable_tablet_landscape', ['on', 'off'])->nullable();
            $table->string('tablet_landscape_adsense')->nullable();

            $table->enum('disable_tablet_portrait', ['on', 'off'])->nullable();
            $table->string('tablet_portrait_adsense')->nullable();

            $table->enum('disable_phone', ['on', 'off'])->nullable();
            $table->string('phone_adsense')->nullable();

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
        Schema::dropIfExists('web_ads');
    }
}
