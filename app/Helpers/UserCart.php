<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Facades\App\Models\AppSetting;
use Facades\App\Models\Coupon;
use Facades\App\Models\RestaurantWrokingDay;
use Facades\App\Models\Cart;
use Facades\App\Models\Food;
use Facades\App\Models\Restaurant;


use Session;
use Response;
use Str;
use DateTime;
use DateTimeImmutable;
use DatePeriod;
use DateInterval;

class UserCart
{
    /**
     * @return array
     */


    public function getCustomerItems()
    
    {
       
      $carts = [];
       if(auth()->check())
       {
       
        $carts = Cart::where('user_id',auth()->id())->get();
        if(!$carts)
        {
          return $carts;
        } else return $carts;


       }
       	return $carts;     
   }


    public function cartstore()
    {

     if(auth()->check())
       {
         $restaurant_id = Cart::where('user_id',auth()->id())->first();

if($restaurant_id)
{
   $restaurant_id = $restaurant_id->food_id;

         $restaurant_id = Food::find($restaurant_id)->restaurant_id;

         return $cartstore = Restaurant::find($restaurant_id);
       } else return null;
        
       }
        return null;
     }



}