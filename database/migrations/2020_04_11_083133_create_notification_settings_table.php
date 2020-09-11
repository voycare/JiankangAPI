<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->boolean('consultation')->default(true);
            $table->boolean('site_visit')->default(true);
            $table->boolean('second_option')->default(true);
            $table->boolean('chat')->default(true);
            $table->boolean('call')->default(true);
            $table->boolean('review')->default(true);
            $table->boolean('clinic_applicants')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
