<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionAnswerTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_answer_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('answer_campaign_id')->unsigned();
            $table->foreign('answer_campaign_id')->references('id')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('answer_surveyer_id')->unsigned();
            $table->foreign('answer_surveyer_id')->references('id')
                ->on('surveyer_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('answer_question_id')->unsigned();
            $table->foreign('answer_question_id')->references('id')
                ->on('question_tbl')->onDelete('cascade')->onUpdate('cascade');            
            $table->string('answer_participate_mobile');
            $table->foreign('answer_participate_mobile')->references('participate_mobile')
                ->on('participate_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('question_answer_type');
            $table->string('question_answer_title');
            $table->string('question_answer_option_1')->nullable();
            $table->string('question_answer_option_2')->nullable();
            $table->string('question_answer_option_3')->nullable();
            $table->string('question_answer_option_4')->nullable();
            $table->string('question_answer_text_value')->nullable();
            $table->string('question_answer_validate_type')->nullable();
            $table->string('question_answer_validate')->nullable();
            $table->string('question_answer_status')->default(0);
            $table->string('question_answer_created_by')->nullable();
            $table->string('question_answer_updated_by')->nullable();
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
        Schema::dropIfExists('question_answer_tbl');
    }
}
