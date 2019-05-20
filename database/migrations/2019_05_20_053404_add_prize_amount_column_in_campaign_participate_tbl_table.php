<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrizeAmountColumnInCampaignParticipateTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_participate_tbl', function (Blueprint $table) {
            $table->float('participate_prize_amount')->after('campaign_participate_address')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_participate_tbl', function (Blueprint $table) {
            //
        });
    }
}
