<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_demands', function (Blueprint $table) {
            $table->id();
            $table->date("date")->nullable();
            $table->string("audio_type")->nullable();
            $table->string("image")->nullable();
            $table->json("audio_link")->nullable();
            $table->json("audio_file")->nullable();
            $table->enum("status",["active","inactive"])->nullable();
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
        Schema::dropIfExists('on_demands');
    }
}
