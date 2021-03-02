<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderOffer extends Model
{
        protected $table = 'order_offers';
    protected $fillable = [
        'order_number', 
        'status',
        'status_note',
        'reason',
        'data'   
    ];

    protected $primaryKey = 'id';
    public $timestamps = true;
}
