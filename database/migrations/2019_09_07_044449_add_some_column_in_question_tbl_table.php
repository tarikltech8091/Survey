<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnInQuestionTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_tbl', function (Blueprint $table) {
            $table->string('question_image')->after('question_option_new')->nullable();
            $table->string('question_video')->after('question_option_new')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_tbl', function (Blueprint $table) {
            //
        });
    }
}
