<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipateTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participate_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('participate_name')->nullable();
            $table->string('participate_name_slug')->nullable();
            $table->string('participate_email')->index()->nullable();
            $table->string('participate_join_date')->nullable();
            $table->string('participate_mobile')->unique()->index();
            $table->string('participate_age')->nullable();
            $table->string('participate_zone')->nullable();
            $table->string('participate_district')->nullable();
            $table->string('participate_address')->nullable();
            $table->string('participate_post_code')->nullable();
            $table->string('participate_nid')->index()->nullable();
            $table->string('participate_gender')->index()->nullable();
            $table->string('participate_religion')->index()->nullable();
            $table->string('participate_occupation')->index()->nullable();
            $table->string('participate_profile_image')->nullable();
            $table->float('participate_total_earn')->default(0);
            $table->float('participate_total_paid_earn')->default(0);
            $table->integer('participate_number_of_campaign')->default(0);
            $table->integer('participate_number_of_gift_winner')->default(0);
            $table->string('agreed_user')->default(0);
            $table->string('participate_status')->default(0);
            $table->string('participate_created_by');
            $table->string('participate_updated_by');
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
        Schema::dropIfExists('participate_tbl');
    }
}
