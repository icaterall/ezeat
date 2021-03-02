<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Driver
 * @package App\Models
 * @version March 25, 2020, 9:47 am UTC
 *
 * @property \App\Models\User user
 * @property integer user_id
 * @property double delivery_fee
 * @property integer total_orders
 * @property double earning
 * @property boolean available
 */
class Rider extends Model
{

    public $table = 'rider_users';
    public $primaryKey = 'id';



    public $fillable = [
    'name',   
    'email', 
    'mobile',  
    'is_active',  
    'is_approved', 
    'is_available',   
    'role',
    'uuid'    
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'mobile' => 'string',
        'is_approved' => 'boolean',
        'is_available' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
        //'user_id' => 'required|exists:users,id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function riderProfile()
    {
        return $this->hasMany(\App\Models\RiderProfile::class, 'rider_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function location()
    {
        return $this->hasMany(\App\Models\RiderLocation::class, 'rider_id');
    }
}
