<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoneTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone_name')->index();
            $table->string('zone_name_slug');
            $table->string('zone_zip_code')->index();
            $table->string('zone_district')->nullable();
            $table->string('zone_upzilla')->nullable();
            $table->string('zone_address_details')->nullable();
            $table->string('zone_status')->default(0);
            $table->string('zone_created_by')->nullable();
            $table->string('zone_updated_by')->nullable();
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
        Schema::dropIfExists('zone_tbl');
    }
}
