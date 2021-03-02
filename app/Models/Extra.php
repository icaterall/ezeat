<?php

namespace App\Models;

use Eloquent as Model;

class Extra extends Model
{

    public $table = 'extras';  
    public $fillable = [
        'name',
        'description',
        'price',
        'restaurant_price',
        'food_id',
        'selection_type',
        'extra_group_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'description' => 'string',
        'price' => 'double',
        'food_id' => 'integer',
        'extra_group_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'price' => 'nullable|numeric|min:0',
        'food_id' => 'required|exists:foods,id',
        'extra_group_id' => 'required|exists:extra_groups,id'
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
     
    ];

     public function getVariationExtras($variation_id)
    {
        return $this
            ->Join('variation_extras', $this->table.'.id', '=', 'variation_extras.extra_id')
            ->where('variation_extras.variation_id',$variation_id)
            ->get();
    }

     public function getVariationExtraId($food_id)
    {
        return $this
            ->Join('variation_extras', $this->table.'.id', '=', 'variation_extras.extra_id')
            ->where($this->table.'.food_id',$food_id)
            ->pluck( $this->table.'.id')->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function food()
    {
        return $this->belongsTo(\App\Models\Food::class, 'food_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function extraGroup()
    {
        return $this->belongsTo(\App\Models\ExtraGroup::class, 'extra_group_id', 'id');
    }


}
