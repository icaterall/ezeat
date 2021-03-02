<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantCuisine extends Model
{
        protected $table = 'restaurant_cuisines';

    protected $fillable = [
        'cuisine_id',
        'restaurant_id',
    ];
    

    /**

     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_cuisines');
    }

    public function cuisines()
    {
        return $this->belongsTo(Cuisine::class);
    }

}
