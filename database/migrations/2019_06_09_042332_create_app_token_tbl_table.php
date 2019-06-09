<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTokenTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_token_tbl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('imei_no')->nullable();
            $table->string('app_key')->nullable();
            $table->string('access_token')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('access_browser')->nullable();
            $table->string('access_city')->nullable();
            $table->string('access_division')->nullable();
            $table->string('access_country')->nullable();
            $table->string('referenceCode')->nullable();
            $table->string('token_status')->default(0);
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
        Schema::dropIfExists('app_token_tbl');
    }
}
