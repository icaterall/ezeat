<?php
/**
 * File name: 2019_08_29_213821_create_restaurants_table.php
 * Last modified: 2020.05.03 at 10:56:45
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 127);
            $table->string('address', 255)->nullable();
            $table->string('latitude', 24);
            $table->string('longitude', 24);
            $table->string('phone', 50)->nullable();
            $table->string('mobile', 50);
            $table->string('email', 255)->nullable();
            $table->text('information')->nullable();
            $table->string('logo', 50)->nullable();
            $table->string('banner', 50)->nullable();
            $table->string('preparing_time', 50);
            $table->double('min_order', 8, 2)->default(0);
            $table->double('delivery_fee', 8, 2)->default(0);
            $table->double('delivery_range', 8, 2)->default(0);//added
            $table->double('default_tax', 8, 2)->default(0); // //added
            $table->boolean('accept_cash')->default(0); // //added
            $table->boolean('free_delivery')->default(0); // //added
            $table->boolean('has_riders')->default(0); // //added
            $table->char('delivery_or_pickup',1)->default('a'); //added
            $table->boolean('food_truck')->default(0); //added
            $table->boolean('active')->default(0); // //added
            


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
        Schema::drop('restaurants');
    }
}
