<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_questions', function (Blueprint $table) {
            $table->id();
            $table->integer("contest_id")->nullable();
            $table->string("question")->nullable();
            $table->string("option_one")->nullable();
            $table->string("option_two")->nullable();
            $table->string("option_three")->nullable();
            $table->string("option_four")->nullable();
            $table->string("answer")->nullable();
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('contest_questions');
    }
}
