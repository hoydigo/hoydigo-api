<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('country_id', 3);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('name', 100);
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
        Schema::dropIfExists('cities');
    }
}
