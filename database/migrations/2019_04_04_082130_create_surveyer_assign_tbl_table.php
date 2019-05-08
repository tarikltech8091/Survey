<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyerAssignTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveyer_assign_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('assign_surveyer_id')->unsigned();
            $table->foreign('assign_surveyer_id')->references('id')
                ->on('surveyer_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('assign_surveyer_name');
            $table->foreign('assign_surveyer_name')->references('surveyer_name')
                ->on('surveyer_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('assign_surveyer_mobile');
            $table->foreign('assign_surveyer_mobile')->references('surveyer_mobile')
                ->on('surveyer_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('assign_campaign_id')->unsigned();
            $table->foreign('assign_campaign_id')->references('id')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('assign_campaign_name');
            $table->foreign('assign_campaign_name')->references('campaign_name')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('assign_zone');
            $table->foreign('assign_zone')->references('zone_name')
                ->on('zone_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('assign_target')->default(0);
            $table->integer('complete_target')->default(0);
            $table->float('surveyer_prize_amount')->default(0);
            $table->string('validate_refference')->nullable();
            $table->string('assign_campaign_complain')->nullable();
            $table->string('assign_campaign_description')->nullable();
            $table->string('success_status')->nullable()->default(0);
            $table->string('assign_status')->default(0);
            $table->string('assign_created_by')->nullable();
            $table->string('assign_updated_by')->nullable();
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
        Schema::dropIfExists('surveyer_assign_tbl');
    }
}
