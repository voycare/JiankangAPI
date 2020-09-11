<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_cancellations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('appointment_id');
            $table->bigInteger('client_id');
            $table->tinyInteger('why_cancel')->nullable();
            $table->text('note')->nullable();
            $table->text('admin_note')->nullable();
            $table->boolean('provide_options')->nullable();
            $table->boolean('use_again')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('fee')->nullable();
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
        Schema::dropIfExists('appointment_cancellations');
    }
}
