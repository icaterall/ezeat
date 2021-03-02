<?php

namespace App\Criteria\Restaurants;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Session;
/**
 * Class RestaurantOfLocationCriteria.
 *
 * @package namespace App\Criteria\Restaurants;
 */
class RestaurantFilterCuisineCriteria implements CriteriaInterface
{

    /**
     * @var array
     */
    private $restaurants;

    public function __construct($restaurants)
    {
        $this->restaurants = $restaurants;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
          
            return $model
            ->join('cuisines','restaurant_cuisines.cuisine_id', '=', 'cuisines.id')
            ->select('restaurant_cuisines.*',
                'cuisines.name as cuisine_name',
                DB::raw('count(cuisines.id) as cuisine_number'),
                'cuisines.id as cuisine_id'
            )
            ->whereIn('restaurant_cuisines.restaurant_id', $this->restaurants->pluck('id'))
            ->groupBy('cuisines.name');
    }
}
