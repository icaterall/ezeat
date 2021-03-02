<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_extras', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('variation_id')->unsigned();
        $table->integer('extra_id')->unsigned();
        $table->double('price', 8, 2)->nullable()->default(0);
        $table->double('restaurant_price', 8, 2)->nullable()->default(0);
        $table->timestamps();
        $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variation_extras');
    }
}
