<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('statement_no')->nullable();
            $table->bigInteger('from_id')->nullable();
            $table->bigInteger('to_id')->nullable();
            $table->timestamp('sale_period')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->float('gross', 16, 2)->nullable();
            $table->float('refund', 16, 2)->nullable();
            $table->float('fee', 16, 2)->nullable();
            $table->float('net', 16, 2)->nullable();
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
        Schema::dropIfExists('statements');
    }
}
