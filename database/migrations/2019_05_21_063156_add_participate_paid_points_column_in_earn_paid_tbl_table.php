<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParticipatePaidPointsColumnInEarnPaidTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('earn_paid_tbl', function (Blueprint $table) {
            $table->integer('participate_paid_points')->after('earn_paid_participate_mobile')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('earn_paid_tbl', function (Blueprint $table) {
            //
        });
    }
}
