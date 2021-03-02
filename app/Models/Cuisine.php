<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{   
    public $table = 'cuisines';
    public $fillable = [
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'restaurants'
    ];


  
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function restaurants()
    {
        return $this->belongsToMany(\App\Models\Restaurant::class, 'restaurant_cuisines');
    }


    public function cuisines()
    {
        return $this->hasMany(RestaurantCuisine::class);
    }
        /**
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getRestaurantsAttribute()
    {
        return $this->restaurants()->get(['restaurants.id', 'restaurants.name']);
    }
}
