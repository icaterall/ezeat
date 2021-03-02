<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Facades\DB;
use Session;


/**
 * Class Restaurant
 * @package App\Models

 */
class Restaurant extends Model
{
    public $table = 'restaurants';


    public $fillable = [
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
        'available_for_delivery',
        'food_truck',
        'admin_commission', 
        'bank_account', 
        'bank_name',  
        'bank_owner', 
        'available_for_pickup',
        'featured',   
        'closed',  
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'name'=> 'string',
        'address'=> 'string',
        'latitude'=> 'string',
        'longitude'=> 'string',
        'phone'=> 'string',
        'mobile'=> 'string',
        'email'=> 'string',
        'information'=> 'text',
        'logo'=> 'string',
        'banner'=> 'string',
        'preparing_time'=> 'string',
        'min_order'=> 'string',
        'delivery_fee'=> 'double',
        'delivery_range'=> 'double',
        'default_tax'=> 'double',
        'accept_cash'=> 'boolean',
        'free_delivery'=> 'boolean',
        'has_riders'=> 'boolean',     
        'delivery_or_pickup'=> 'char',
        'food_truck'=> 'boolean',       
        'active'=> 'boolean'
    ];



    public function getRateAttribute()
    {
        return $this->restaurantReviews()->select(DB::raw('round(AVG(restaurant_reviews.rate),1) as rate'))->first('rate')->rate;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function foods()
    {
        return $this->hasMany(\App\Models\Food::class, 'restaurant_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function restaurantReviews()
    {
        return $this->hasMany(\App\Models\RestaurantReview::class, 'restaurant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_restaurants');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function cuisines()
    {
        return $this->belongsToMany(\App\Models\Cuisine::class, 'restaurant_cuisines');
    }

    public function discountables()
    {
        return $this->morphMany('App\Models\Discountable', 'discountable');
    }



    public function nearRestaurants()
    {
            $myLat = Session::get('user_lat');
            $myLon = Session::get('user_long');
           
            if(Session::get('order_type') == 'pickup')
            {
                return $restaurants = \DB::table('restaurants')
                    ->select('restaurants.*')
                    ->selectRaw("6371 * acos(
                            cos( radians($myLat) )
                            * cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians($myLon) )
                            + sin( radians($myLat) )
                            * sin( radians( latitude ) )
                        ) AS 'distance'")
                
                ->selectRaw(" '0' AS 'is_open'")    
                ->selectRaw(" '0' AS 'open_at'")
                ->leftJoin('restaurant_cuisines', 'restaurants.id', '=', 'restaurant_cuisines.restaurant_id')
                ->leftJoin('coupons', 'restaurants.id', '=', 'coupons.restaurant_id')
                ->leftJoin('restaurant_working_days', 'restaurants.id', '=', 'restaurant_working_days.restaurant_id')
                ->where('restaurants.active', '1')
                ->where('restaurants.available_for_pickup', 1)
                ->groupBy('id')
                ->havingRaw(" `distance`  < `delivery_range` ")
                ->orderBy('distance');


            } else 

            {
                              return $restaurants = \DB::table('restaurants')
                    ->select('restaurants.*')
                    ->selectRaw("6371 * acos(
                            cos( radians($myLat) )
                            * cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians($myLon) )
                            + sin( radians($myLat) )
                            * sin( radians( latitude ) )
                        ) AS 'distance'")
                
                ->selectRaw(" '0' AS 'is_open'")    
                ->selectRaw(" '0' AS 'open_at'")
                ->leftJoin('restaurant_cuisines', 'restaurants.id', '=', 'restaurant_cuisines.restaurant_id')
                ->leftJoin('coupons', 'restaurants.id', '=', 'coupons.restaurant_id')
                ->leftJoin('restaurant_working_days', 'restaurants.id', '=', 'restaurant_working_days.restaurant_id')
                ->where('restaurants.active', '1')
                ->where('restaurants.available_for_delivery', 1)
                ->groupBy('id')
                ->havingRaw(" `distance`  < `delivery_range` ")
                ->orderBy('distance');
            }


    }

    
// Current restaurant

    public function thisRestaurant($RestaurantID)
    {
        $myLat = Session::get('user_lat');
        $myLon = Session::get('user_long');
                return $restaurants = \DB::table('restaurants')
                    ->select('restaurants.*')
                    ->where('restaurants.id', $RestaurantID)
                    ->selectRaw("6371 * acos(
                            cos( radians($myLat) )
                            * cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians($myLon) )
                            + sin( radians($myLat) )
                            * sin( radians( latitude ) )
                        ) AS 'distance'")
                
                    ->selectRaw(" 0 AS 'day_id'")
                    ->selectRaw(" 0 AS 'open_time'")
                    ->selectRaw(" 0 AS 'close_time'")
                    ->selectRaw(" 0 AS 'open_at_time'")
                    ->havingRaw(" `distance`  < `delivery_range` ");
    }
}
