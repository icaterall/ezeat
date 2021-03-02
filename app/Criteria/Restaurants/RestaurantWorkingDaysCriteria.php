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
class RestaurantWorkingDaysCriteria implements CriteriaInterface
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
        ->join('restaurants', 'restaurant_working_days.restaurant_id', '=', 'restaurants.id')
        ->join('days', 'restaurant_working_days.day_id', '=', 'days.id')
       ->select('restaurant_working_days.*',

                'days.name as day_name',
                'days.id as day_id'
            );




   }
}
