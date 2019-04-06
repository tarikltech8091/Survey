<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_slug');
            $table->string('user_type');
            $table->string('user_role');
            $table->string('email');
            $table->string('password');
            $table->string('user_mobile');
            $table->string('nid')->nullable();
            $table->string('district')->nullable();
            $table->string('upzilla')->nullable();
            $table->string('post_code')->nullable();
            $table->string('user_profile_image')->nullable();
            $table->integer('surveyer_id')->nullable();
            $table->integer('requester_id')->nullable();
            $table->timestamp('last_login');
            $table->string('login_status');
            $table->string('status');
            $table->rememberToken();
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::drop('users');
    }
}
