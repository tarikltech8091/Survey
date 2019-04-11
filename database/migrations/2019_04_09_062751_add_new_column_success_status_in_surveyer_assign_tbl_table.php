<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnSuccessStatusInSurveyerAssignTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveyer_assign_tbl', function (Blueprint $table) {
            $table->string('success_status')->after('assign_campaign_description')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveyer_assign_tbl', function (Blueprint $table) {
            //
        });
    }
}
