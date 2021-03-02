<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodPriceFoodOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_orders', function (Blueprint $table) {
            $table->double('food_price', 8, 2)->default(0)->after('restaurant_price');
            $table->double('food_price_restaurant', 8, 2)->default(0)->after('restaurant_price');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_orders', function (Blueprint $table) {
            //
        });
    }
}
