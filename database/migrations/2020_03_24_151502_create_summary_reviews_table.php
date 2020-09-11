<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summary_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('clinic_id');
            $table->bigInteger('star_5')->default(0);
            $table->bigInteger('star_4')->default(0);
            $table->bigInteger('star_3')->default(0);
            $table->bigInteger('star_2')->default(0);
            $table->bigInteger('star_1')->default(0);
            $table->decimal('star',2,1)->default(0);
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
        Schema::dropIfExists('summary_reviews');
    }
}
