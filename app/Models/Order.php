<?php

namespace App\Models;

use Eloquent as Model;
use Facades\App\Models\Earning;
use Facades\App\Models\RiderWallet;
use Facades\App\Helpers\Helper;
use Facades\App\Helpers\GetRider;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line
use DB;
use Auth;
use Carbon\Carbon;
class Order extends Model
{
    //use SoftDeletes; //add this line
    public $table = 'orders';
    


    public $fillable = [      
        'user_id',
        'order_status_id',
        'order_status_note',
        'tax',
        'restaurant_tax',
        'delivery_fee_restaurant',
        'discount_restaurant',
        'delivery_fee',
        'time',
        'date',
        'tips',
        'discount',
        'service_charge',
        'subtotal',
        'restaurant_subtotal',
        'total',
        'restaurant_total',
        'is_cash',
        'isdelivery',
        'secret',
        'promo_code',
        'hint',
        'order_type',
        'active',
        'driver_id',
        'delivery_address_id',
        'estimated_time',
        'job_execute',
        'restaurant_payout_id',
        'payment_status',
        'is_app',
         'created_at'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'order_status_id' => 'integer',
        'tax' => 'double',
        'hint' => 'string',
        'status' => 'string',
        'delivery_address_id' => 'integer',
        'delivery_fee'=>'double',
        'active'=>'boolean',
        'driver_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'order_status_id' => 'required|exists:order_statuses,id',
        'driver_id' => 'nullable|exists:rider_users,id',
    ];


      public function GetRestaurantOrders()
     {


        if (auth()->user()->hasRole('manager')) {
            return $this->join("food_orders", "orders.id", "=", "food_orders.order_id")
                ->join("foods", "foods.id", "=", "food_orders.food_id")
                ->join("user_restaurants", "user_restaurants.restaurant_id", "=", "foods.restaurant_id")
                ->where('user_restaurants.user_id', auth()->user()->id)
                ->where('orders.payment_status', 1)
                ->orderBy('orders.id', 'DESC')
                ->groupBy('orders.id')
                
                ->select('orders.*')->get();
            }
}


        public function GetAllOrders()
        {

            return $this->join("food_orders", "orders.id", "=", "food_orders.order_id")
                ->join("foods", "foods.id", "=", "food_orders.food_id")
                ->join("restaurants", "restaurants.id", "=", "foods.restaurant_id")
                 ->select('orders.*',"restaurants.id as restaurant_id")
                 ->groupBy(['orders.id'])->get();
       }

       
        public function GetRestaurantPayment()
        {


           $payment_period = Helper::getKeyValue('restaurant_payment_period');
            return $this->

            join("food_orders", "orders.id", "=", "food_orders.order_id")
                ->join("foods", "foods.id", "=", "food_orders.food_id")
                ->join("restaurants", "restaurants.id", "=", "foods.restaurant_id")
               
             
                 ->where('orders.active',1)

                 ->select('orders.*',"restaurants.id as restaurant_id")
                 ->where('orders.created_at', '<=', Carbon::now()->subDays($payment_period)->toDateTimeString())
                 ->groupBy(['orders.id'])


       ->where('orders.restaurant_payout_id',Null)

                 ->get();
       }


    public function GetAdminAmount()
    {
       $orders = $this
        ->where('active',1)
        ->orderBy('id', 'DESC')
         ->get();

         $admin_payment = $orders->sum('total');
         $restaurant_payment = $orders->sum('restaurant_total');
         $restaurant_payment_pending = Earning::get()->sum('restaurant_earning');
         $riders_payment = RiderWallet::get()->sum('total_amount');
         $riders_payment_pending = RiderWallet::get()->sum('value');         
         $admin_commission = number_format($admin_payment - $restaurant_payment - $riders_payment, 2, '.', ',');

return array(
            'admin_payment'   => 0,
            'restaurant_payment' => 0,
            'restaurant_payment_pending'   => 0,
            'riders_payment'   => 0,
            'riders_payment_pending' => 0,
            'admin_commission'   => 0
                   );
  
/*return array(
            'admin_payment'   => number_format($admin_payment, 2, '.', ','),
            'restaurant_payment' => number_format($restaurant_payment, 2, '.', ','),
            'restaurant_payment_pending'   => number_format($restaurant_payment_pending, 2, '.', ','),
            'riders_payment'   => number_format($riders_payment, 2, '.', ','),
            'riders_payment_pending' => number_format($riders_payment_pending, 2, '.', ','),
            'admin_commission'   => number_format($admin_commission, 2, '.', ',')
                   );*/

    }


        public function getRider($order)
        {
           
            if(($order->isdelivery == 1) AND ($order->has_riders == 0) AND ($order->order_status_id != 1) AND ($order->driver_id == null))
                     
            {
                
                    $distance = Helper::getKeyValue('rider_distance');
                    $limit = Helper::getKeyValue('rider_limit');
                    $uuid = GetRider::CheckIfRiderHasNotification($order->id,$distance,$limit);
            }
        }

    public function GetManagerAmount($orders,$restaurant_id)
    {

         $restaurant_payment = $orders->sum('total');
         $restaurant_payment_pending = Earning::where('restaurant_id',$restaurant_id)->first();
         if($restaurant_payment_pending != null)
         {$restaurant_payment_pending = $restaurant_payment_pending->restaurant_earning;
         } else $restaurant_payment_pending = 0;
        

return array(

            'restaurant_payment' => number_format($restaurant_payment, 2, '.', ','),
            'restaurant_payment_pending'   => number_format($restaurant_payment_pending, 2, '.', ','),

                   );
    }




    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function restaurant()
    {
        return $this->belongsTo(\App\Models\Restaurant::class, 'restaurant_id', 'id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function riders()
    {
        return $this->belongsTo(\App\Models\Rider::class, 'driver_id', 'id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function orderStatus()
    {
        return $this->belongsTo(\App\Models\OrderStatus::class, 'order_status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function foodOrders()
    {
        return $this->hasMany(\App\Models\FoodOrder::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function foods()
    {
        return $this->belongsToMany(\App\Models\Food::class, 'food_orders');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_orders');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function deliveryAddress()
    {
        return $this->belongsTo(\App\Models\DeliveryAddress::class, 'delivery_address_id', 'id');
    }
    
}