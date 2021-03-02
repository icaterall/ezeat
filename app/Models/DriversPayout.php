<?php
/**
 * File name: DriversPayout.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Models;

use Eloquent as Model;

/**
 * Class DriversPayout
 * @package App\Models
 * @version March 25, 2020, 9:48 am UTC
 *
 * @property \App\Models\User user
 * @property integer user_id
 * @property string method
 * @property double amount
 * @property dateTime paid_date
 * @property string note
 */
class DriversPayout extends Model
{

    public $table = 'drivers_payouts';
    


    public $fillable = [
        'rider_id',
        'method',
        'amount',
        'paid_date',
        'driver_payout_id',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rider_id' => 'integer',
        'method' => 'string',
        'amount' => 'double',
        'paid_date' => 'datetime',
        'note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rider_id' => 'required|exists:users,id',
        'method' => 'required',
        'note' => 'required',
        'amount' => 'required|min:0.01',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function driver()
    {
        return $this->belongsTo(\App\Models\Rider::class, 'rider_id', 'id');
    }
    
}
