<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignFeedbackTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_feedback_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('feedback_question_id')->unsigned();
            $table->bigInteger('feedback_campaign_id')->unsigned();
            $table->string('feedback_user_type')->nullable();
            $table->string('feedback_mobile_number');
            $table->string('feedback_district')->nullable();
            $table->string('feedback_zone')->nullable();
            $table->string('feedback_post_code')->nullable();
            $table->string('feedback_description')->nullable();
            $table->string('feedback_status')->default(0);
            $table->string('is_true')->default(0);
            $table->string('feedback_created_by');
            $table->string('feedback_updated_by');
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
        Schema::dropIfExists('campaign_feedback_tbl');
    }
}
