<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestaurantTaxOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('restaurant_tax', 5, 2)->nullable()->default(0)->after('tax');
            $table->double('delivery_fee_restaurant', 5, 2)->nullable()->default(0)->after('delivery_fee');
            $table->double('discount_restaurant', 5, 2)->nullable()->default(0)->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
