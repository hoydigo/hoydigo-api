<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('position_id', 6);
            $table->foreign('position_id')->references('id')->on('positions');
            $table->string('political_position_id', 3);
            $table->foreign('political_position_id')->references('id')->on('political_positions');
            $table->string('political_party_id', 3);
            $table->foreign('political_party_id')->references('id')->on('political_parties');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('twitter_username')->nullable();
            $table->string('twitter_description')->nullable();
            $table->string('twitter_url')->nullable();
            $table->boolean('twitter_verified')->nullable();
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
        Schema::dropIfExists('influencers');
    }
}
