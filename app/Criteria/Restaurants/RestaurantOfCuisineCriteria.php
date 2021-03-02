<?php

namespace App\Criteria\Restaurants;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Session;
/**

 *
 * @package namespace App\Criteria\Restaurants;
 */
class RestaurantOfCuisineCriteria implements CriteriaInterface
{


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
            ->join('restaurants','restaurant_cuisines.restaurant_id', '=', 'restaurants.id')
            ->join('cuisines','restaurant_cuisines.cuisine_id', '=', 'cuisines.id')
            ->select('restaurant_cuisines.*',
                'cuisines.name as cuisine_name',
                'cuisines.id as cuisine_id'
            );
   }
}
