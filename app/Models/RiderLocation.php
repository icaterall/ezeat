<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiderLocation extends Model
{
        protected $table = 'rider_locations';
    protected $fillable = [
        'lat', 
        'long',
        'current',
        'rider_id'
    ];

    protected $primaryKey = 'id';
    public $timestamps = true;




}
