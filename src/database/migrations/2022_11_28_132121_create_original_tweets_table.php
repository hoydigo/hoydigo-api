<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOriginalTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('original_tweets', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('conversation_id')->nullable();
            $table->string('author_id')->nullable();
            $table->boolean('retweeted')->default(false);
            $table->string('original_author_username')->nullable();
            $table->string('original_author_id')->nullable();
            $table->text('tweet')->nullable();
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
        Schema::dropIfExists('original_tweets');
    }
}
