<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question_title')->index();
            $table->string('question_type');
            $table->string('question_campaign_name');
            $table->bigInteger('question_campaign_id')->unsigned();
            $table->integer('question_position');
            $table->string('question_special')->nullable();
            $table->string('question_option_1');
            $table->string('question_option_2');
            $table->string('question_option_3');
            $table->string('question_option_4')->nullable();
            $table->string('question_option_new')->nullable();
            $table->integer('question_points')->default(0);
            $table->string('question_published_date')->nullable();
            $table->string('question_published_status')->default(0);
            $table->string('question_status')->default(0);
            $table->string('question_created_by')->nullable();
            $table->string('question_updated_by')->nullable();
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
        Schema::dropIfExists('question_tbl');
    }
}
