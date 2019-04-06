<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyerTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveyer_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surveyer_name')->index();
            $table->string('surveyer_name_slug');
            $table->string('surveyer_email')->index();
            $table->string('surveyer_mobile')->unique()->index();
            $table->string('surveyer_join_date');
            $table->string('surveyer_district');
            $table->string('surveyer_address');
            $table->string('surveyer_post_code');
            $table->string('surveyer_nid')->index();
            $table->string('surveyer_zone')->nullable();
            $table->string('surveyer_profile_image')->nullable();
            $table->integer('surveyer_total_participate')->default(0);
            $table->integer('surveyer_total_success_participate')->nullable();
            $table->float('surveyer_total_earn')->default(0);
            $table->float('surveyer_total_paid')->default(0);
            $table->string('surveyer_status')->default(0);
            $table->string('surveyer_created_by');
            $table->string('surveyer_updated_by');
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
        Schema::dropIfExists('surveyer_tbl');
    }
}
