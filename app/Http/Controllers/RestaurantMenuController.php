<?php

namespace App\Http\Controllers;

use App\Criteria\Restaurants\RestaurantOfCuisineCriteria;
use App\Criteria\Restaurants\RestaurantFilterCuisineCriteria;
use App\Criteria\Restaurants\RestaurantWorkingDaysCriteria;



use App\Repositories\RestaurantRepository;
use App\Repositories\RestaurantCuisineRepository;
use App\Repositories\RestaurantWDaysRepository;


use Facades\App\Helpers\Helper;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantCuisine;
use Facades\App\Models\RestaurantWrokingDay;
use Facades\App\Models\AppSetting;
use Facades\App\Models\Category;
use Facades\App\Helpers\UserCart;
use Facades\App\Models\Cart;
use App\Models\User;

use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Session;
use Carbon\Carbon;
use Route;
use Auth;
class RestaurantMenuController extends Controller
{
    private $restaurantRepository;
    private $restaurantFilterCuisineRepository;
    private $restaurantCuisineRepository;
    private $restaurantWorkingRepository;

    public function __construct(RestaurantCuisineRepository $restaurantFilterCuisineRepo, RestaurantCuisineRepository $restaurantCuisineRepo, RestaurantWDaysRepository $restaurantWDaysRepo)
    {
        $this->restaurantFilterCuisineRepository = $restaurantFilterCuisineRepo;
        $this->restaurantCuisineRepository = $restaurantCuisineRepo;
        $this->restaurantWorkingRepository = $restaurantWDaysRepo;

    }




/*Show Store Details */
   public function getRestaurantMenu($RestaurantID, $RestaurantName)
    {
      

        $now = Carbon::now();
        $day_id = $now->format('N');
        $today_date = $now->format('Y-m-d');
        
        $restaurant = Restaurant::find($RestaurantID);

        session()->forget('delivery_fee');
        $user_street = Session::get('streetaddress');

        if (Session::get('preorder_type') == null) {

        Session::put(['preorder_type' => 'asap']);
        }

      if (Session::get('isdelivery') != 'pickup') {
       Session::put(['isdelivery' => 'delivery']);
              }
      $isdelivery=Session::get('isdelivery');

   // Clear order schdule 
     if(Session::get('restaurant_id') != $RestaurantID)
      {
            session()->forget('preorder_day_id');  
            session()->forget('preorder_time_value');
            session()->forget('print_day_time');
            session()->forget('restaurant_id');
            session()->forget('pre_order_value');
      }
       
       Session::put(['restaurant_id' => $RestaurantID]);

        $lat = Session::get('user_lat');
        $lng = Session::get('user_long');

         $store_coverage = 0;
        $store_distance  = 0;
        $location = true;


if($lat != null)
{
          $query = Restaurant::thisRestaurant($RestaurantID);
          $data = $query->first();
        if($data)
        {
          $store_coverage = $data->delivery_range;
          $store_distance  = $data->distance;

        } 
       
        else // If Data is Null
       
        {
          $location = false;
           $query = \DB::table('restaurants')
                    ->select('restaurants.*')
                    ->where('restaurants.id', $RestaurantID)
                    ->selectRaw("0 AS 'distance'")
                    ->selectRaw(" 0 AS 'day_id'")
                    ->selectRaw(" 0 AS 'open_time'")
                    ->selectRaw(" 0 AS 'close_time'")
                    ->selectRaw(" 0 AS 'open_at_time'");
        }    
}

else
{
  $query = \DB::table('restaurants')
                    ->select('restaurants.*')
                    ->where('restaurants.id', $RestaurantID)
                    ->selectRaw("0 AS 'distance'")
                    ->selectRaw(" 0 AS 'day_id'")
                    ->selectRaw(" 0 AS 'open_time'")
                    ->selectRaw(" 0 AS 'close_time'")
                    ->selectRaw(" 0 AS 'open_at_time'");

        $data = $query->first();
        $store_coverage = $data->delivery_range;
        $store_distance  = $data->distance;

}
 
              if($store_coverage > $store_distance)
              {
                $is_far=0;
              }
              else
              {
                $is_far=1;
                $delivery_fee = 0.01;
              }
              if($location == false)
              {
                $is_far=1;
                $delivery_fee = 0.01; 
              }


      $data = $query->first();
   


     // Get at what time store will be open
     if($data != null)
     { 

      $data = Helper::isStoreOpen($data);
           /*   Get The open Days for preOrder Calender     */
           $calender_days = Helper::findOpenDaysTime($RestaurantID);
           
           $working_hours=Helper::findOpenHours($RestaurantID,$today_date);
     
              /*      END DELIVERY TIME   */
                          //Get All cuisines for all restaurants
           $this->restaurantCuisineRepository->pushCriteria(new RestaurantOfCuisineCriteria());            
           $cuisines = $this->restaurantCuisineRepository->get();

           $store_address = $restaurant->address;



       $foods = $restaurant->foods()->where('deliverable',1)->orderBy('category_id',
                  'asc')->with('category')->orderBy('position',
                  'asc')->get()->groupBy('category_id');
 
             $food_categories=[];      
            foreach ($foods as $key => $food) {
            $categories = $food->first()->category();
            $food_categories[]=$categories->first()->id; 
            }

            $categories = Category::whereIn('id',$food_categories)->get();
            $storeID=[];
            $storeID[] = $RestaurantID;
            $getPromotions = Helper::restaurantCoupon($storeID);
            Session::put(['delivery_fee' => $data->delivery_fee]);

           $is_store_will_open = Helper::isStoreWillOpenToday($RestaurantID);
           
           if($lat!=null){   
            $is_location_exist = 1; 
            } // if there is no location SET
            else {
                $is_location_exist = 0;
                 }
  

if($data->available_for_delivery == false)
   {
    session()->forget('order_type');
    Session::put(['order_type' => 'pickup']);
  }

if($data->available_for_pickup == false)
   {
    session()->forget('order_type');
    Session::put(['order_type' => 'delivery']);
  }



return view('restaurant.details',compact('is_store_will_open','is_location_exist','is_far','working_hours','calender_days','cuisines', 'foods','data', 'categories','isdelivery','getPromotions'));
         
  } else {
    return \Redirect::route('home');
  }  


    }

  


// Pre Order

    public function preOrder(Request $request)
    {  
       $now = Carbon::now();
       $today = $now->format('Y-m-d');

            $order_date = $request->day_id;
            if($request->time_value == 'now')
            {

                $order_time = $now->format('h:i a');
            }
            
            else

            {
              $order_time = $request->time_value;
            }
           
           session()->forget('preorder_type');  
            if(Session::get('isdelivery') == 'pickup')
            {
              $isdelivery='Pickup';
            }
                else
            {
                  $isdelivery='Delivery';  
            }
       

       $getDate = strtotime($order_date);
       
       $order_date = date('Y-m-d',$getDate);




      if($order_date == $today)
      {
        $get_day_name='Today'; 
      } 

      else 

      {
        $get_day_name = date('D d -M',$getDate);
      }

if($request->time_value !='now')
    
    {       
       $preorder_time_name = Carbon::createFromFormat('H:i', $request->time_value)->format('h:i a');

       Session::put(['preorder_type' => 'preorder']);
    }    

    else
    {
      $preorder_time_name='ASAP';
      Session::put(['preorder_type' => 'asap']);
    }
      session()->forget('preorder_date');  
      session()->forget('preorder_time');
      session()->forget('print_day_time');
      session()->forget('store_id');
      session()->forget('pre_order_value');

     $print_day_time = $isdelivery.' on '.$get_day_name.' '.$preorder_time_name;
          
      Session::put(['preorder_date' => $order_date]);
      Session::put(['preorder_time' => $order_time]);

      Session::put(['print_day_time' => $print_day_time]);
      Session::put(['store_id' => $request->store_id]);

      Session::put(['pre_order_value' => 1]); // Order has been schudeled
      

// Return to Ajax

       return Response::json([
            'print_day_time' => $print_day_time,
            'pre_order_value' => Session::get('pre_order_value'),
        ]);
   

 }



// openHours

    public function openHours(Request $request)
    {


$working_hours=Helper::findOpenHours($request->store_id,$request->date);

 $customizeview = view('restaurant.time_lap', compact('working_hours'))->render();

        return Response::json([
            'customizeview' => $customizeview,
        ]);


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index()
    {
        //
    }



/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
