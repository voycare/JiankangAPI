<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('appointment_id')->nullable();
            $table->string('name')->nullable();
            $table->string('type', 30)->nullable();
            $table->bigInteger('admin_id')->nullable();
            $table->text('path')->nullable();
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
        Schema::dropIfExists('appointment_documents');
    }
}
