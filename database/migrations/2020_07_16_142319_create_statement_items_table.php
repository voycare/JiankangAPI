<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statement_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('statement_id');
            $table->timestamp('item_date')->nullable();
            $table->string('item_name')->nullable();
            $table->bigInteger('appointment_no')->nullable();
            $table->float('amount', 16, 2)->nullable();
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
        Schema::dropIfExists('statement_items');
    }
}
