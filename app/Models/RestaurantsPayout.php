<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class RestaurantsPayout
 * @package App\Models
 * @version March 25, 2020, 9:48 am UTC
 *
 * @property \App\Models\Restaurant restaurant
 * @property integer restaurant_id
 * @property string method
 * @property double amount
 * @property dateTime paid_date
 * @property string note
 */
class RestaurantsPayout extends Model
{

    public $table = 'restaurants_payouts';
    


    public $fillable = [
        'restaurant_id',
        'method',
        'amount',
        'paid_date',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'restaurant_id' => 'integer',
        'method' => 'string',
        'amount' => 'double',
        'paid_date' => 'datetime',
        'note' => 'string'
    ];





    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function restaurant()
    {
        return $this->belongsTo(\App\Models\Restaurant::class, 'restaurant_id', 'id');
    }
    
}
