<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarnTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earn_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('earn_user_type');
            $table->string('earn_type');
            $table->bigInteger('earn_surveyer_id')->nullable()->unsigned();
            $table->foreign('earn_surveyer_id')->references('id')
                ->on('surveyer_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('earn_surveyer_mobile_number')->nullable();
            $table->foreign('earn_surveyer_mobile_number')->references('surveyer_mobile')
                ->on('surveyer_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('earn_participate_id')->nullable()->unsigned();
            $table->foreign('earn_participate_id')->references('id')
                ->on('participate_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('earn_participate_mobile_number')->nullable();
            $table->foreign('earn_participate_mobile_number')->references('participate_mobile')->on('participate_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('earn_campaign_id')->unsigned()->unsigned();
            $table->foreign('earn_campaign_id')->references('id')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('earn_campaign_name')->nullable();
            $table->foreign('earn_campaign_name')->references('campaign_name')
                ->on('campaign_tbl')->onDelete('cascade')->onUpdate('cascade');
            $table->string('earn_date')->nullable();
            $table->float('earn_amount');
            $table->string('earn_status')->default(0);
            $table->string('earn_created_by')->nullable();
            $table->string('earn_updated_by')->nullable();
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
        Schema::dropIfExists('earn_tbl');
    }
}
