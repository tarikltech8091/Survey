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
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')
                ->on('question_tbl')->onDelete('cascade')->onUpdate('cascade');            
            $table->bigInteger('participate_id')->unsigned();
            $table->foreign('participate_id')->references('id')
                ->on('participate_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('participate_mobile');
            $table->string('question_answer_type');
            $table->string('question_title');
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
