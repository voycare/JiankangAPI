<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('doctor_id');
            $table->bigInteger('clinic_id');
            $table->timestamp('date')->nullable();
            $table->integer('status')->default(0)->comment('0:inactive,1:active');
            $table->tinyInteger('state')->nullable();
            $table->integer('mode')->comment('1:video,2:written');
            $table->integer('type_id')->default(1)->comment('1:Appointment, 2:Second Request');
            $table->tinyInteger('specialty_id')->nullable();
            $table->tinyInteger('treatment_id')->nullable();
            $table->bigInteger('interpreter_id')->nullable();
            $table->string('admin_notify_ids')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
