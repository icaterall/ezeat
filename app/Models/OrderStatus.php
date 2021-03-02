<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class OrderStatus
 * @package App\Models
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @property string status
 */
class OrderStatus extends Model
{

    public $table = 'order_statuses';

    public $fillable = [
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status' => 'required'
    ];
  
    
}
