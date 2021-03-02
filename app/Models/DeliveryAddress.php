<?php

namespace App\Models;

use Eloquent as Model;

class DeliveryAddress extends Model
{

    public $table = 'delivery_addresses';
    

    public $fillable = [
        'description',
        'address',
        'latitude',
        'longitude',
        'is_default',
        'suite_floor',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'is_default' => 'boolean',
        'suit_floor' => 'string',
        'user_id' => 'integer'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
