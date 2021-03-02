<?php
/**
 * File name: 2019_08_31_111104_create_orders_table.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_status_id')->unsigned();
            $table->double('tax', 5, 2)->nullable()->default(0);
            $table->double('delivery_fee', 5, 2)->nullable()->default(0);
            $table->string('time')->nullable();
            $table->string('date')->nullable();
            $table->double('tips', 5, 2)->nullable()->default(0);
            $table->double('discount', 5, 2)->nullable()->default(0);
          $table->double('subtotal', 5, 2)->nullable()->default(0);
          $table->double('restaurant_subtotal', 5, 2)->nullable()->default(0);
          $table->double('total', 5, 2)->nullable()->default(0);      
        $table->double('restaurant_total', 5, 2)->nullable()->default(0);
        $table->boolean('is_cash')->default(0); // added
        $table->boolean('isdelivery')->default(1); // added
            $table->string('secret')->nullable();
            $table->string('promo_code')->nullable();
            $table->text('hint')->nullable();
            $table->string('order_type')->nullable();
            $table->boolean('active')->default(1); // added
            $table->integer('driver_id')->nullable();
            $table->integer('delivery_address_id')->nullable()->unsigned();


            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('delivery_address_id')->references('id')->on('delivery_addresses')->onDelete('set null')->onUpdate('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
