<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParticipateTotalEarnPointsColumnInParticipateTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participate_tbl', function (Blueprint $table) {
            $table->float('participate_total_paid_points')->after('participate_profile_image')->nullable()->default(0);
            $table->float('participate_total_earn_points')->after('participate_profile_image')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participate_tbl', function (Blueprint $table) {
            //
        });
    }
}
