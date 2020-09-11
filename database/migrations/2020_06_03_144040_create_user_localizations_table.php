<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_localizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('default_country')->nullable();
            $table->string('timezone', 40)->nullable();
            $table->string('language', 10)->nullable();
            $table->string('currency_code', 20)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->tinyInteger('date_format')->nullable();
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
        Schema::dropIfExists('user_localizations');
    }
}
