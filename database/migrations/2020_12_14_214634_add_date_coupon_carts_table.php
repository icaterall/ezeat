<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateCouponCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
          $table->string('time')->nullable()->after('quantity'); // added
          $table->string('date')->nullable()->after('quantity'); // added
          $table->integer('coupon_id')->nullable()->after('quantity'); // added
          $table->string('order_type')->default('asap')->after('quantity'); // added

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
        });
    }
}
