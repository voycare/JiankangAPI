<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('clinic_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('type_clinic')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('website')->nullable();
            $table->integer('year_in_business')->nullable();
            $table->integer('specialty_id')->nullable();
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
        Schema::dropIfExists('clinic_profiles');
    }
}
