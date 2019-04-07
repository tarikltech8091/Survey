<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campaign_name')->index();
            $table->string('campaign_name_slug');
            $table->string('campaign_category')->nullable();
            $table->string('campaign_title')->nullable();
            $table->string('campaign_requester_name');
            $table->bigInteger('campaign_requester_id')->unsigned();
            $table->string('campaign_requester_mobile');
            $table->string('campaign_create_date');
            $table->string('campaign_start_date');
            $table->string('campaign_end_date');
            $table->integer('campaign_num_of_days')->default(0);
            $table->string('campaign_unique_code')->nullable();
            $table->float('campaign_total_cost');
            $table->float('campaign_total_cost_paid')->default(0);
            $table->float('campaign_cost_for_surveyer')->nullable();
            $table->float('campaign_prize_amount')->nullable();
            $table->string('campaign_physical_prize')->nullable();
            $table->string('campaign_zone')->nullable();
            $table->integer('campaign_total_num_of_zone')->default(0);
            $table->integer('campaign_target_user')->nullable();
            $table->string('campaign_image')->nullable();
            $table->string('campaign_description')->nullable();
            $table->string('campaign_payment_status')->default(0);
            $table->string('campaign_published_status')->default(0);
            $table->string('campaign_status')->default(0);
            $table->string('campaign_created_by')->nullable();
            $table->string('campaign_updated_by')->nullable();
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
        Schema::dropIfExists('campaign_tbl');
    }
}
