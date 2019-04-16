<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignParticipateTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_participate_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('participate_campaign_id')->unsigned();
            $table->foreign('participate_campaign_id')->references('id')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('participate_campaign_name');
            $table->foreign('participate_campaign_name')->references('campaign_name')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('campaign_participate_mobile');
            $table->foreign('campaign_participate_mobile')->references('participate_mobile')
                ->on('participate_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('campaign_participate_occupation')->nullable();
            $table->string('campaign_participate_age')->nullable();
            $table->string('campaign_participate_district')->nullable();
            $table->string('campaign_participate_post_code')->nullable();
            $table->string('campaign_participate_zone')->nullable();
            $table->string('campaign_participate_address')->nullable();
            $table->string('campaign_participate_status')->default(0);
            $table->string('campaign_participate_created_by')->nullable();
            $table->string('campaign_participate_updated_by')->nullable();
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
        Schema::dropIfExists('campaign_participate_tbl');
    }
}
