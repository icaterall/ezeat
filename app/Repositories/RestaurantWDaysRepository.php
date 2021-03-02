<?php

namespace App\Repositories;

use App\Models\RestaurantWrokingDay;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class RestaurantWDaysRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
     'restaurant_id', 
     'day_id',
     'open_time',
     'close_time',
     'available'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RestaurantWrokingDay::class;
    }
}
