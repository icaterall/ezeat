<?php

namespace App\Http\Controllers;

use App\Criteria\Restaurants\RestaurantOfCuisineCriteria;
use App\Criteria\Restaurants\RestaurantFilterCuisineCriteria;
use App\Criteria\Restaurants\RestaurantWorkingDaysCriteria;
use Facades\App\Helpers\UserCart;


use App\Repositories\RestaurantRepository;
use App\Repositories\RestaurantCuisineRepository;
use App\Repositories\RestaurantWDaysRepository;


use Facades\App\Helpers\Helper;
use Facades\App\Models\Restaurant;
use App\Models\RestaurantCuisine;
use App\Models\RestaurantWrokingDay;
use App\Models\AppSetting;

use App\Models\User;




use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Session;
use Carbon\Carbon;
use Route;
class RestaurantsSearchController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



 //Save To Session

    public function initialSearch(Request $request)
    {
        
        if (!empty($request->thislat)) {
            session()->forget('fulladdress');
            session()->forget('streetaddress');
            session()->forget('user_lat');
            session()->forget('user_long');
            session()->forget('order_type');

            Session::put(['streetaddress' => $request->street_address]);
            Session::put(['fulladdress' => $request->fulladdress]);
            Session::put(['user_lat' => $request->thislat]);
            Session::put(['user_long' => $request->thislong]);          
            
        }
        return redirect('/restaurants/search');
    }



   // Used by address form on store page
    public function updateAddress(Request $request)
    {
        if (!empty($request->thislat)) {
            session()->forget('fulladdress');
            session()->forget('streetaddress');
            session()->forget('user_lat');
            session()->forget('user_long');

            Session::put(['streetaddress' => $request->street_address]);
            Session::put(['fulladdress' => $request->fulladdress]);
            Session::put(['user_lat' => $request->thislat]);
            Session::put(['user_long' => $request->thislong]);          
            
        }
        $result['status'] = 'success';

    }

 //Get All restaurants

    public function paginateSearch(Request $request)
    {

       if((session::get('user_lat'))!=null)
        
        {
           
              $restaurants = $this->getRestaurants($request);         
              
              //for filtering these restaurants
               $restaurantsIDs[] = null;
               foreach ($restaurants as $key => $restaurant) {
                  $restaurantsIDs[] = $restaurant->id;
                } 

            Helper::usePaginate();

           // get Cusisines only for filter without duplicate in cuisine name
            $this->restaurantFilterCuisineRepository->pushCriteria(new RestaurantFilterCuisineCriteria($restaurants));            
            $cuisinefilters = $this->restaurantFilterCuisineRepository->get();

           //Get All cuisines for all restaurants
           $this->restaurantCuisineRepository->pushCriteria(new RestaurantOfCuisineCriteria());            
           $cuisines = $this->restaurantCuisineRepository->get();
           //Get Working days for all restaurants
           $this->restaurantWorkingRepository->pushCriteria(new RestaurantWorkingDaysCriteria());            
           $restaurantdays = $this->restaurantWorkingRepository->get();
           $count = $restaurants->count();
            $restaurants = $restaurants->paginate(12);
            
            $freedelivery = Restaurant::whereIn('id',$restaurantsIDs)->where('free_delivery',1)->get(); 
            $restaurants_coupons = Helper::restaurantCoupon($restaurantsIDs);
            $restaurantFilterCoupon = Helper::restaurantFilterCoupon($restaurantsIDs);
            $open_at=Helper::getKeyValue('open_at');
            $close_at=Helper::getKeyValue('close_at');
            $isapp_open=Helper::isAppOpen($open_at,$close_at); 

            $storeWhours = RestaurantWrokingDay::all();

            if ($request->ajax()) {
                $view = view('store-search.stores_listing', compact(
                    'restaurants','restaurantdays','isapp_open','storeWhours','cuisines','restaurants_coupons'
            ))->render();

                return response()->json(['html'=>$view]);
            }
           return view('store-search.archive', (     
            [
                           'restaurants' => $restaurants,
                            'cuisines' => $cuisines,
                            'restaurantdays' => $restaurantdays,
                            'cuisinefilters' => $cuisinefilters,
                            'isapp_open' => $isapp_open,
                            'freedelivery' => $freedelivery,
                            'storeWhours' => $storeWhours,
                            'restaurantFilterCoupon' => $restaurantFilterCoupon,
                            'count' => $count,
                            'restaurants_coupons' => $restaurants_coupons
            ]
         ));
       }
       else{
           return \Redirect::route('home');
       } 

 }


    // Used by filters
    public function ajaxFilter(Request $request)
    {
  
if(Session::get('user_lat')!=null)
      {  
         
       $restaurants = $this->getRestaurants($request); 
           $count = $restaurants->count();

             Helper::usePaginate();      
            $restaurants = $restaurants->paginate(12);  
            
            //Get All cuisines for all restaurants
           $this->restaurantCuisineRepository->pushCriteria(new RestaurantOfCuisineCriteria());            
           $cuisines = $this->restaurantCuisineRepository->get();

           //Get Working days for all restaurants
           $this->restaurantWorkingRepository->pushCriteria(new RestaurantWorkingDaysCriteria());            
           $restaurantdays = $this->restaurantWorkingRepository->get();
            $storeWhours = RestaurantWrokingDay::all();
            $open_at=Helper::getKeyValue('open_at');
            $close_at=Helper::getKeyValue('close_at');
            $isapp_open=Helper::isAppOpen($open_at,$close_at);   
            $restaurants_coupons = Helper::restaurantCoupon(0);
            return response()->view('store-search.stores_listing', compact('restaurants','restaurantdays','isapp_open','storeWhours','cuisines','count','restaurants_coupons'));
      }
    }





    private function getRestaurants($request)
    {
    

    $coupons = json_decode($request->offers);
    $cuisines = json_decode($request->cuisines);
    $freedelivery = json_decode($request->freedelivery);  
    $restaurants = Restaurant::nearRestaurants();

             //for filtering these restaurants
               $restaurantsIDs[] = null;
               foreach ($restaurants->get() as $key => $restaurant) {

                  $restaurantsIDs[] = $restaurant->id;
                } 


    if (!empty($cuisines)) {
     
      $restaurants->whereIn('restaurant_cuisines.cuisine_id', $cuisines);
    
    }

    if (!empty($coupons)) {
        $restaurants_coupons = Helper::restaurantCoupon($restaurantsIDs);

       

        $restaurants->whereIn('coupons.restaurant_id', $restaurants_coupons);
    


    }

    if (!empty($freedelivery)) {
     $restaurants->where('free_delivery' , 1);
    }

    $restaurants = $restaurants->get();
    
   $restaurants = Helper::isStoreListOpen($restaurants);

    return $restaurants;
  }



        public function DeliveryPickup(Request $request)
    {


      session()->forget('order_type');
   
      if($request->status == 'pickup')
          {
            Session::put(['order_type' => 'pickup']);
          } 
     
      else
      {
          Session::put(['order_type' => 'delivery']);
      }

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
