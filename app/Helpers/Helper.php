<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Facades\App\Models\AppSetting;
use Facades\App\Models\Coupon;
use Facades\App\Models\Order;
use Facades\App\Models\OrderOffer;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantWrokingDay;
use Session;
use Response;
use Str;
use DateTime;
use DateTimeImmutable;
use DatePeriod;
use DateInterval;
use Geocoder;
use Benwilkins\FCM\FcmMessage;

class Helper
{
    /**
     * @return array
     */


    public function toFcm($order)
    {
        $message = new FcmMessage();
        $notification = [
            'title'        => "New Order #".$order->id." to ".$order->foodOrders[0]->food->restaurant->name,
            'body'         => $order->user->name,
            'icon'         => 'https://spoongate.com/csfiles/icon.png',
            'click_action' => "FLUTTER_NOTIFICATION_CLICK",
            'id' => config('services.fcm.key'),
            'status' => 'done',
        ];
        $message->content($notification)->data($notification)->priority(FcmMessage::PRIORITY_HIGH);

        return $message;
    }



  function getaddress($lat,$lng)
  {

    $param = array("latlng"=>"$lat,$lng");     
    return $response = \Geocoder::geocode('json', $param);       


  }

public function GetOrderInArray($order_id)
{

     $order = Order::find($order_id);
     $restaurant = $order->foods->first()->restaurant;
     $order_status = OrderOffer::where('order_number', $order_id)
            ->first();

foreach($order->foodOrders as $foods){

     $order_items[] = [ 
                        'item_name' => $foods->food->name,
                        'item_size' => $foods->food_size,
                        'item_qty' => $foods->quantity,
                      ]; 
                }



      $date = Carbon::parse($order->created_at);
      $isToday = $date->isToday();
      $isTomorrow = $date->isTomorrow();
        if($isToday == true)
        {
           $isTodayOrTomorrow ='Today';
        } elseif($isTomorrow == true)
          {
             $isTodayOrTomorrow ='Tomorrow'; 
          } else
            {
              $isTodayOrTomorrow = date('D d-m-Y', strtotime($order->created_at));  
            }


$orderdate = Carbon::parse($order->date);

$isOrderToday = $orderdate->isToday();

$isOrderTomorrow = $orderdate->isTomorrow();

  if($isOrderToday == true)
    {
      $isOrderTodayOrTomorrow ='Today';
    } elseif($isOrderTomorrow == true)
      {
       $isOrderTodayOrTomorrow ='Tomorrow'; 
      } else
        {
         $isOrderTodayOrTomorrow = date("D d-m-Y",strtotime($order->date));  
        }

$order_date = $isOrderTodayOrTomorrow;
$order_time = date("h:i a",strtotime($order->time));
$order_subtotal ='MYR '.$order->subtotal;
$restaurant_subtotal ='MYR '.$order->restaurant_subtotal;


      if($order->tax != 0)
      {
        $order_tax ='MYR '.$order->tax;
      } else $order_tax = 0;

      if($order->delivery_fee != 0)
      {
        $delivery_fee ='MYR '.$order->delivery_fee;
      } else $delivery_fee = 0;
      if($order->discount != 0)
      {
        $discount ='MYR '.$order->discount;
      } else $discount = 0;
      if($order->tips != 0)
      {
        $order_tips ='MYR '.$order->tips;
      } else $order_tips = 0;


$active = 'n';
$is_cash = 'n';
if($order->active == 1)
$active = 'y';
if($order->is_cash == 1)
$is_cash = 'y';


 $totalpayment ='MYR '.$order->total;
// Fixed Order info
    $order_information[] = [
        'order_number' => $order->id,
        'order_created_at' => date('h:i a, Y-m-d', strtotime($order->created_at)),
        'order_time' => $order_time,
        'order_date' => date("D d-m-Y",strtotime($order->date)),
        'order_instruction' => $order->order_notes,
        'customer_name' => $order->user->name,
        'customer_phone' => $order->user->mobile,
        'restaurant_name' => $restaurant->name,
        'restaurant_phone' => $restaurant->mobile,
        'restaurant_address' => $restaurant->address,
        'order_subtotal' => $order_subtotal,
        'restaurant_subtotal' => $restaurant_subtotal,
        'customer_tax' => $order_tax,
        'delivery_fee' =>$delivery_fee,
        'discount' => $discount,
        'order_tips' => $order_tips,
        'total_payment' => $totalpayment,
        'user_address' => $order->deliveryAddress->address,
        'active' => $active,
        'is_cash' => $is_cash,
        'promotion_applied' => $order->promo_code,
        'order_items' => $order_items,

    ];
return $order_information;
}
  

//-------------------------------------------  


    public function usePaginate()
    {
        if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate', function ($perPage = 25, $page = null, $options = []) {
                $options['path'] = $options['path'] ?? request()->path();
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

                return new LengthAwarePaginator(
                        $this->forPage($page, $perPage)->values(),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    );
            });
        }
    }


//Get App Setting Value
  public function getKeyValue($keyValue)

  {
    
      $ref = AppSetting::get()->toArray();
      $data = array_map(function($obj){
        return (array) $obj;
            }, $ref);
          
      foreach ($data as $key => $value) {

         if($value['key'] == $keyValue)
         {
            return $value['value'];
            break;
         }
       }
       
  }


    //Download PDF
    public function getPdfOrder($order_id)
    {
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $order = Order::find($order_id);
            // This  $data array will be passed to our PDF blade
            $data = [
                    'order' => $order
            ];
        return $data;

        }



    public function isAppOpen($open_at,$close_at)
    {
        // Check if store is available that day
        $now = Carbon::now();
        $day = $now->format('N');
        // Check store hours
        $app_open = Carbon::createFromFormat('H:i', $open_at);
        $app_close = Carbon::createFromFormat('H:i', $close_at);

        if ($now >= $app_open && $now <= $app_close) {
            return true;
        }       
        
        return false;
    }




public function restaurantFilterCoupon($restaurantsIDs) {

    
    if($restaurantsIDs == 0)
    {
     $promofilter_restaurants = Coupon::where('restaurant_id','!=',null)
                    ->where('user_id',null)
                    ->where('enabled',1)
                    ->get();
    }

    else{
      $promofilter_restaurants = Coupon::where('restaurant_id','!=',null)
                    ->where('user_id',null)
                    ->where('enabled',1)    
                    ->whereIn('restaurant_id',$restaurantsIDs)
                    ->get();     
    }


   return $promofilter_restaurants; 
    }                


public function restaurantCoupon($restaurantsIDs) {
     $today_date = Carbon::now();
     $restaurantcoupons = $this->restaurantFilterCoupon($restaurantsIDs);
        $promo_restaurants=null;
        
       if($restaurantcoupons)  
       { 
        foreach ($restaurantcoupons as $key => $getPromotion) {
        $data_difference = ($today_date->diffInDays($getPromotion->expiration_date, false)) + 1;
                if(!($data_difference <= 0))
                {
                $promo_restaurants[]=[
                  'restaurant_id' => $getPromotion->restaurant_id,
                  'discount' => $getPromotion->discount,
                   'code' => $getPromotion->code,
                   'minimum_order' => $getPromotion->minimum_order,
                   ]; 
                 }   
           }
      }      
    return $promo_restaurants;
  }


// Check if Restaurant is open Now

    public function isOpenAt($StoreID,$today)
    {

         
      // Get all available Next days
      $nextDay = RestaurantWrokingDay::where('restaurant_id', $StoreID)
      ->Where('available',1)
      ->where('day_id','>',$today)
      ->first();
            
            // Get all available previous days
      $previousDay = RestaurantWrokingDay::where('restaurant_id',$StoreID)
            ->Where('available',1)
            ->where('day_id','<=',$today)
            ->OrderBy('day_id','asc')
            ->first();

      if($nextDay)
      {
                  $when_open_day = $nextDay->day_id;
                  $open_day_string = date('D', strtotime("Sunday +$when_open_day  days")); 
                  $store_open = Carbon::createFromFormat('H:i', $nextDay->open_time);
                  $store_close = Carbon::createFromFormat('H:i', $nextDay->close_time);
                  $store_open_time = $store_open->format('h:i a');  
                  $store_open_hr =$store_open->format('H:i');
                  $store_close_hr =$store_close->format('H:i');                

$OpenDays[]=
[

   'day_id'=>$when_open_day,
   'open_time'=>$store_open_hr,
   'close_time'=>$store_close_hr,
    'open_text'=>$open_day_string.' '.$store_open_time,
];

      return $OpenDays;
      }

      else if($previousDay)
            {
              

                        $when_open_day = $previousDay->day_id;
                        $open_day_string = date('D', strtotime("Sunday +$when_open_day  days")); 
                        $store_open = Carbon::createFromFormat('H:i', $previousDay->open_time);
                        $store_close = Carbon::createFromFormat('H:i', $previousDay->close_time);
                        $store_open_time = $store_open->format('h:i a'); 

                        $store_open_hr =$store_open->format('H:i');
                        $store_close_hr =$store_close->format('H:i'); 

          

          $OpenDays[]=
[

   'day_id'=>$when_open_day,
   'open_time'=>$store_open_hr,
   'close_time'=>$store_close_hr,
    'open_text'=>$open_day_string.' '.$store_open_time,
];

      return $OpenDays;


            }
        
        else
        {
          return 'Permanently closed';
        }

      }


    public function isStoreListOpen($stores)
    {
        // Check if store is available that day
        $now = Carbon::now();
        $day = $now->format('N');
    
    
foreach ($stores as $store) {

        $storeDay = RestaurantWrokingDay::where('restaurant_id', $store->id)
            ->where('day_id', $day)
            ->where('available', 1)
            ->first();

//if not available today
        if ($storeDay == null) {
            $store->is_open = 0;
            $open_days = $this->isOpenAt($store->id,$day);   
            if($open_days == 'Permanently closed')
             $store->open_at ='Permanently closed';    
             else $store->open_at = $open_days[0]['open_text'];
        }


else {
        // Check store hours
        $store_open = Carbon::createFromFormat('H:i', $storeDay->open_time);
        $store_close = Carbon::createFromFormat('H:i', $storeDay->close_time);
        $when_open_day = $storeDay->day_id;
        $open_day_string = date('D', strtotime("Sunday +$when_open_day  days"));
        $store_open_time = $store_open->format('h:i a'); 

       
        if ($now >= $store_open && $now <= $store_close) {
            $store->is_open = 1;
        }       
        
        else if($now < $store_open) // will open soon today

        {
                $store->is_open = 0;
                $store->open_at = $store_open_time;

        } else

        {
            $store->is_open=0;
             $open_days = $this->isOpenAt($store->id,$day);
            $store->open_at =$open_days[0]['open_text'];

        }
   }
}

return $stores;
    }




    public function isStoreOpen($store)
    {
        // Check if store is available that day   
        $now = Carbon::now();
        $day = $now->format('N');
        $storeDay = RestaurantWrokingDay::where('restaurant_id', $store->id)
            ->where('day_id', $day)
            ->where('available', 1)
            ->first();


//if not available today
        if (!$storeDay) {
            $store->is_open  =0;
            $open_days = $this->isOpenAt($store->id,$day);
            if($open_days != 'Permanently closed')
            {           $store->day_id =$open_days[0]['day_id'];
                        $store->open_time =$open_days[0]['open_time'];
                        $store->close_time =$open_days[0]['close_time'];
                        $store->open_at_time =$open_days[0]['open_text'];
            } else {
                      $store->open_at_time = 'Permanently closed';
                      
            }
        }
else {
        // Check store hours
        $store_open = Carbon::createFromFormat('H:i', $storeDay->open_time);
        $store_close = Carbon::createFromFormat('H:i', $storeDay->close_time);
        $when_open_day = $storeDay->day_id;
        $open_day_string = date('D', strtotime("Sunday +$when_open_day  days"));
        $store_open_time = $store_open->format('h:i a'); 
          $open_time = $store_open->format('H:i'); 
           $close_time = $store_close->format('H:i'); 

        if ($now >= $store_open && $now <= $store_close) {
               $store->is_open=1;
                $store->open_at_time = $store_open_time;
                $store->day_id =$day;
                $store->open_time =$open_time;
                $store->close_time =$close_time;
                $store->open_at_time =$store_open_time;
        }       
        
        else if($now < $store_open) // will open soon today

        {
                $store->is_open=0;
                $store->open_at_time = $store_open_time;
                $store->day_id =$day;
                $store->open_time =$open_time;
                $store->close_time =$close_time;
                $store->open_at_time =$store_open_time;

        } else

        {
            $store->is_open=0;
            $open_days = $this->isOpenAt($store->id,$day);
            $store->day_id =$open_days[0]['day_id'];
            $store->open_time =$open_days[0]['open_time'];
            $store->close_time =$open_days[0]['close_time'];
            $store->open_at_time =$open_days[0]['open_text'];
        }
   }

return $store;
    }




public function findOpenHours($Storeid,$date)
{

    $now = Carbon::now();
    $today = $now->format('Y-m-d');

       $getDayId = strtotime($date);      
       $day_id = date('N',$getDayId);
 
$current_time = strtotime($now);

$frac = 900;
$r = $current_time % $frac;

$new_time = $current_time + ($frac-$r);
$new_time = date('H:i', $new_time);
 


      $OpenHours=RestaurantWrokingDay::where('restaurant_id', $Storeid)
      ->Where('day_id',$day_id)
      ->first();
  

  

    $TodayTime = Carbon::parse($new_time);
    $endTodayTime = $TodayTime->addMinutes(45);
    $open_today_time = $endTodayTime->format('H:i');
  


    $StoreTime = Carbon::parse($OpenHours->open_time);
      $today_date = $StoreTime;


    $endStoreTime = $StoreTime->addMinutes(30);

    $open_store_time = $endStoreTime->format('H:i');



if(($today == $date) && ($this->isOpen($Storeid,$now)))
{
 
$period = new DatePeriod(
  new DateTimeImmutable($open_today_time),
  new DateInterval('PT15M'),
  new DateTimeImmutable($OpenHours->close_time),
  DatePeriod::EXCLUDE_START_DATE
);

}
else
{
  $period = new DatePeriod(
  new DateTimeImmutable($open_store_time),
  new DateInterval('PT15M'),
  new DateTimeImmutable($OpenHours->close_time),
  DatePeriod::EXCLUDE_START_DATE
);

}



$slots = [];

if( ($today == $date) && ($this->isOpen($Storeid,$now)) )
{

   $slots[] = ['value' => 'now', 'time-name' => 'ASAP'];
 
}

foreach ($period as $date) {
  $slots[] = ['value' => $date->format('H:i'), 'time-name' => $date->format('h:i A')];
}

return $slots;
}



    public function isStoreWillOpenToday($StoreID)
    {
        // Check if store is available that day
        $now = Carbon::now();
        $day_id = $now->format('N');

        $storeDay = RestaurantWrokingDay::where('restaurant_id', $StoreID)
            ->where('day_id', $day_id)
            ->where('available', 1)
            ->first();

        if (!$storeDay) {
            return false;
        }

        // Check store hours
        $store_open = Carbon::createFromFormat('H:i', $storeDay->open_time);
        $store_close = Carbon::createFromFormat('H:i', $storeDay->close_time);

        if ($now <= $store_close) {
            return true;
        }       
        
        return false;
    }




    public function isOpen($StoreID,$full_date)
    {      
      
        // Check if store is available that day
        $full_date = Carbon::parse($full_date);
        


        $day = $full_date->format('N');

        $storeDay = RestaurantWrokingDay::where('restaurant_id', $StoreID)
            ->where('day_id', $day)
            ->where('available', 1)
            ->first();




        if (!$storeDay) {
            return false;
        }

        // Check store hours
        $store_open = Carbon::createFromFormat('H:i', $storeDay->open_time)->format('H:i');
        $store_close = Carbon::createFromFormat('H:i', $storeDay->close_time)->format('H:i');
        $date = $full_date->format('Y-m-d');
      
        $store_open =  Carbon::parse($date.' '.$store_open);
        $store_close =  Carbon::parse($date.' '.$store_close);





        if ($full_date >= $store_open && $full_date <= $store_close) {
          
          
          return true; 
        
        }       
       
        return false;
    }

public function findOpenDaysTime($Storeid)
{
      $OpenDays=RestaurantWrokingDay::where('restaurant_id', $Storeid)
      ->Where('available',1)
      ->get();

      $checktoday = $this->isOpen($Storeid,Carbon::now());

      $calender_days   = [];
      $period = new DatePeriod(
          new DateTime(),
          new DateInterval('P1D'), 
          7 // Apply the interval 6 times on top of the starting date
      );

foreach ($period as $period_day)
  {
  
foreach ($OpenDays as  $OpenDay) {
  if($period_day->format('N') == $OpenDay->day_id)
  {
    $calender_days[]= [
                
                   'day_id'=>$OpenDay->day_id, 
                   'store_id'=>$Storeid,  
                   'day_text'=>$period_day->format('D'),
                   'day_date'=>$period_day->format('d'), 
                   'full_date'=>$period_day->format('Y-m-d'),            
                   'open_time'=>$OpenDay->open_time,
                   'close_time'=>$OpenDay->close_time,
                 ];
               }
           } 
    }

return $calender_days;

}


public function status()
    {
             return [
                '1' => 'Yes',
                '0' => 'No'
            ];
    }

 public function couponType()
    {
             return [
                'percent' => 'Percent',
                'fixed' => 'Fixed'
            ];
    }   

public function couponUse()
    {
             return [
                '0' => 'Multiple use',
                '1' => 'Single use'
            ];
    }

}