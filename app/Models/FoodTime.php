<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodTime extends Model
{
       protected $table = 'food_times';

    protected $fillable = [
        'name',
    ];

    /**
     * get all hotels related to given service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_item_times');
    }

    public function foodtimes()
    {
        return $this->hasMany(FoodItemTime::class);
    }

    /**
     * get all services for a given language.
     *
     * @param $lang
     * @return mixed
     */
    public function getFoodTimes()
    {
        return $this
            ->pluck('name', 'id')
            ->all();
    }

    /**
     * get all services for a given language for ajax request.
     *
     * @param $lang
     * @return mixed
     */
    public function getFoodTimesAjax()
    {
        return $this
            ->select('name', 'id')
            ->get();
    }
}
