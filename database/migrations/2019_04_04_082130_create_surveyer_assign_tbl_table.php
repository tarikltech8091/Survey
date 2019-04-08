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
            $table->string('assign_surveyer_name');
            $table->string('assign_surveyer_mobile');
            $table->bigInteger('assign_campaign_id')->unsigned();
            $table->string('assign_campaign_name');
            $table->string('assign_zone');
            $table->integer('assign_target')->default(0);
            $table->integer('complete_target')->default(0);
            $table->float('surveyer_prize_amount')->default(0);
            $table->string('validate_refference')->nullable();
            $table->string('assign_campaign_complain')->nullable();
            $table->string('assign_campaign_description')->nullable();
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
