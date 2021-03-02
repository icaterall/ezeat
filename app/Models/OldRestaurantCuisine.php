<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OldRestaurantCuisine extends Model
{
    protected $table = 'restaurant_cuisines';

    protected $fillable = [
        'cuisine_id',
        'restaurant_id',
    ];

    /**
     * get all hotels related to given service.
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

    /**
     * get all services for a given language.
     *
     * @param $lang
     * @return mixed
     */
    public function getFilterCuisines()
    {
    dd('f');
    }


    public function getRestaurantCuisines()
    {
        return $this
            ->join('restaurants', $this->table.'.restaurant_id', '=', 'restaurants.id')
            ->join('cuisines', $this->table.'.cuisine_id', '=', 'cuisines.id')
            ->select(
                $this->table.'.*',

                'cuisines.name as cuisine_name',
                'cuisines.id as cuisine_id'
            )
            ->get();
    }

    /*
     * get all services for a given language for ajax request
     *
     * @param $lang
     * @return mixed
     */
}
