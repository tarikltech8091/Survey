<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarnPaidTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earn_paid_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('earn_paid_user_type');
            $table->bigInteger('earn_paid_surveyer_id')->unsigned()->nullable();
            $table->string('earn_paid_surveyer_mobile')->nullable();            
            $table->bigInteger('earn_paid_participate_id')->unsigned()->nullable();
            $table->string('earn_paid_participate_mobile')->nullable();
            $table->string('earn_paid_date')->nullable();
            $table->string('earn_paid_payment_type');
            $table->float('earn_paid_amount');
            $table->string('payment_transaction_id');
            $table->string('earn_paid_description')->nullable();
            $table->string('earn_paid_status')->default(0);
            $table->string('earn_paid_created_by')->nullable();
            $table->string('earn_paid_updated_by')->nullable();
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
        Schema::dropIfExists('earn_paid_tbl');
    }
}
