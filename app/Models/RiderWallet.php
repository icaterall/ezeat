<?php

namespace App\Models;

use Eloquent as Model;

class RiderWallet extends Model
{

    public $table = 'riders_wallet';
    public $primaryKey = 'id';

    public $fillable = [
    'rider_id',   
    'amount',
    'value'
 
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function rider()
    {
        return $this->hasMany(\App\Models\Rider::class, 'rider_id');
    }




}
