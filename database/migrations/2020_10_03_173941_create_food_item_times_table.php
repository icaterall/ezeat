<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodItemTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_item_times', function (Blueprint $table) {
            
            $table->integer('food_time_id')->unsigned()->index();
            $table->integer('food_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('food_time_id')->references('id')->on('food_times')->onDelete('cascade');
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_item_times');
    }
}
