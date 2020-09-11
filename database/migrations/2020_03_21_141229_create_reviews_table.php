<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('clinic_id');
            $table->bigInteger('transaction_id')->nullable();
            $table->bigInteger('appointment_id')->nullable();
            $table->bigInteger('treatment_id')->nullable();
            $table->string('title')->default('');
            $table->integer('star')->default(0);
            $table->text('content')->nullable();
            $table->timestamp('review_at')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
