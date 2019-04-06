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
            $table->integer('earn_surveyer_or_participate_id');
            $table->string('earn_mobile_number');
            $table->bigInteger('earn_campaign_id')->unsigned();
            $table->string('earn_campaign_name')->nullable();
            $table->string('earn_date')->nullable();
            $table->float('earn_amount');
            $table->string('earn_status')->default(0);
            $table->string('earn_created_by');
            $table->string('earn_updated_by');
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
