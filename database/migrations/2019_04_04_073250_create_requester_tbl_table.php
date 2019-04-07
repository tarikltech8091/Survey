<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequesterTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requester_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('requester_name')->index();
            $table->string('requester_name_slug');
            $table->string('requester_email')->index();
            $table->string('requester_mobile')->unique()->index();
            $table->string('requester_join_date');
            $table->string('requester_district');
            $table->string('requester_address');
            $table->string('requester_post_code');
            $table->string('requester_nid')->index();
            $table->string('requester_profile_image')->nullable();
            $table->integer('requester_number_of_campaign')->default(0);
            $table->integer('requester_number_of_success_campaign')->default(0);
            $table->float('requester_total_invest')->default(0)->nullable();
            $table->float('requester_total_paid')->default(0)->nullable();
            $table->string('requester_status')->default(0);
            $table->string('requester_created_by')->nullable();
            $table->string('requester_updated_by')->nullable();
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
        Schema::dropIfExists('requester_tbl');
    }
}
