<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class FoodOrder
 */
class FoodOrderExtra extends Model
{

    public $table = 'food_order_extras';
    


    public $fillable = [
        'price',
        'restaurant_price',
        'extra_id',
        'extra_group_id',
        'food_order_id'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function extras()
    {
        return $this->belongsTo(\App\Models\Extra::class, 'extra_id','id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function extraGroup()
    {
        return $this->belongsTo(\App\Models\ExtraGroup::class, 'extra_group_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function foodOrder()
    {
        return $this->belongsTo(\App\Models\FoodOrder::class, 'food_order_id', 'id');
    }
}
