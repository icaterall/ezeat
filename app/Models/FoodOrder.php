<?php
/**
 * File name: FoodOrder.php
 * Last modified: 2020.06.11 at 16:10:52
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\Models;

use Eloquent as Model;

/**
 * Class FoodOrder
 * @package App\Models
 * @version August 31, 2019, 11:18 am UTC
 *
 * @property \App\Models\Food food
 * @property \App\Models\Extra[] extras
 * @property \App\Models\Order order
 * @property double price
 * @property integer quantity
 * @property integer food_id
 * @property integer order_id
 */
class FoodOrder extends Model
{

    public $table = 'food_orders';
    


    public $fillable = [
        'price',
        'quantity',
        'food_id',
        'order_id',
        'food_instruction',
        'restaurant_price',
        'food_size',
        'food_price',
        'food_price_restaurant'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'quantity' => 'integer',
        'food_id' => 'integer',
        'order_id' => 'integer'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function food()
    {
        return $this->belongsTo(\App\Models\Food::class, 'food_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function extras()
    {
        return $this->belongsToMany(\App\Models\Extra::class, 'food_order_extras');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function extraOrder()
    {
        return $this->hasMany(\App\Models\FoodOrderExtra::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }
}
