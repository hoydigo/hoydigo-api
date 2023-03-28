<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_tweets', function (Blueprint $table) {
            $table->string('influencer_twitter_id')->nullable();
            $table->string('tweet_twitter_id')->nullable();
            $table->string('conversation_id')->nullable();
            $table->boolean('retweeted')->default(false);
            $table->string('published_at')->nullable();
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
        Schema::dropIfExists('influencer_tweets');
    }
}
