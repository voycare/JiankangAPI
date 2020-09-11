<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('author_id')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->default('');
            $table->text('content')->nullable();
            $table->timestamp('publish_date')->nullable();
            $table->string('tags')->nullable();
            $table->string('source')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });

        Schema::create('news_category', function (Blueprint $table) {
            $table->integer('news_id');
            $table->integer('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_category');
    }
}
