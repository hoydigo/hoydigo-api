<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->string('id', 6)->unique();
            $table->string('country_id', 3);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->integer('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->string('sector', 100);
            $table->string('name', 100);
            $table->string('description', 280);
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
        Schema::dropIfExists('positions');
    }
}
