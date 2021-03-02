<?php

namespace App\Repositories;

use App\Models\RestaurantCuisine;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
class RestaurantCuisineRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cuisine_id',
        'restaurant_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RestaurantCuisine::class;
    }
}
