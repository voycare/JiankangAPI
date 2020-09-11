<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('clinic_id');
            $table->bigInteger('appointment_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('consulation_type')->nullable();
            $table->tinyInteger('payment_type')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->bigInteger('paid_amount')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
