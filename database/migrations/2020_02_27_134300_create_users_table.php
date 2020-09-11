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
            $table->string('email')->default('');
            $table->string('password')->default('');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('provide_id')->default('');
            $table->string('phone')->default('');
            $table->string('country')->nullable();
            $table->integer('age')->nullable();
            $table->integer('gender')->default(0)->comment('0: Male, 1:Female');
            $table->string('otp')->default('');
            $table->integer('birthday')->default(0);
            $table->integer('verify')->default(0);
            $table->string('avatar')->nullable();
            $table->integer('role')->default(0)->comment('0:client,1:clinic, 2:admin');
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
        Schema::dropIfExists('users');
    }
}
