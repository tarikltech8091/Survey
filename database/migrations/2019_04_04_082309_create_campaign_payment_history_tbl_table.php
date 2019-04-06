<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignPaymentHistoryTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_payment_history_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payment_campaign_id')->unsigned();
            $table->string('payment_campaign_name');
            $table->bigInteger('payment_requester_id')->unsigned();
            $table->string('payment_date');
            $table->string('payment_type');
            $table->float('payment_amount');
            $table->string('payment_transaction_id');
            $table->string('payment_status')->default(0);
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
        Schema::dropIfExists('campaign_payment_history_tbl');
    }
}
