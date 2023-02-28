<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadioSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radio_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer("radio_id")->nullable();
            $table->string("rss_name")->nullable();
            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->string("summary")->nullable();
            $table->json("days")->nullable();
            $table->string("time_zone")->nullable();
            $table->time("start_time")->nullable();
            $table->time("end_time")->nullable();
            $table->string("start_time_utc_0")->nullable();
            $table->string("end_time_utc_0")->nullable();
            $table->string("thumbnail")->nullable();
            $table->string("main_image")->nullable();
            $table->enum("status",["active","inactive"]);
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
        Schema::dropIfExists('radio_schedules');
    }
}
