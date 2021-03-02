<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationExtra extends Model
{
        public $table = 'variation_extras';
    
    public $fillable = [
        'variation_id',
        'extra_id',        
        'price',
        'restaurant_price'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function extra()
    {
        return $this->belongsTo(\App\Models\Extra::class, 'extra_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function variation()
    {
        return $this->belongsTo(\App\Models\Variation::class, 'variation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function extraGroup()
    {
        return $this->belongsTo(\App\Models\ExtraGroup::class, 'extra_group_id', 'id');
    }

}
