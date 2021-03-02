<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class RestaurantRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @method Restaurant findWithoutFail($id, $columns = ['*'])
 * @method Restaurant find($id, $columns = ['*'])
 * @method Restaurant first($columns = ['*'])
 */
class RestaurantRepository extends BaseRepository implements CacheableInterface
{

    use CacheableRepository;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'mobile',
        'email',
        'information',
        'logo',
        'banner',
        'preparing_time',
        'min_order',
        'delivery_fee',
        'delivery_range',
        'default_tax',
        'accept_cash',
        'free_delivery',
        'has_riders',     
        'delivery_or_pickup',
        'food_truck',       
        'active',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Restaurant::class;
    }

    /**
     * get my restaurants
     */

    public function myRestaurants()
    {
        return Restaurant::join("user_restaurants", "restaurant_id", "=", "restaurants.id")
            ->where('user_restaurants.user_id', auth()->id())->get();
    }

    public function myActiveRestaurants()
    {
        return Restaurant::join("user_restaurants", "restaurant_id", "=", "restaurants.id")
            ->where('user_restaurants.user_id', auth()->id())
            ->where('restaurants.active','=','1')->get();
    }

}
