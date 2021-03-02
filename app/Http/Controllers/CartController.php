<?php

namespace App\Http\Controllers;

use App\Criteria\Restaurants\RestaurantOfCuisineCriteria;
use App\Criteria\Restaurants\RestaurantFilterCuisineCriteria;
use App\Criteria\Restaurants\RestaurantWorkingDaysCriteria;
use App\Repositories\RestaurantRepository;
use App\Repositories\RestaurantCuisineRepository;
use App\Repositories\RestaurantWDaysRepository;
use Facades\App\Helpers\Helper;
use Facades\App\Helpers\UserCart;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantCuisine;
use Facades\App\Models\RestaurantWrokingDay;
use Facades\App\Models\AppSetting;
use Facades\App\Models\Category;

use Facades\App\Models\Food;
use Facades\App\Models\Variation;
use Facades\App\Models\VariationExtra;
use Facades\App\Models\Cart;
use Facades\App\Models\ExtraGroup;
use Facades\App\Models\Extra;
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
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.

class CartController extends Controller
{



//Store URL in session
    public function storeURL(Request $request)
    {
    
   if ($request->ajax()) {
   

        //check if the previous page route name is 'congresses.registration'
        if(Route::getRoutes()->match(Request::create(\URL::previous()))->getName() == 'RestaurantMenu') {
            Session::put(['current_url' => Request::create(\URL::previous())->getRequestUri()]);
        }

} 

   else  return \Redirect::route('home');
    }


//get Product Details in Modal
    public function getFoodDetail(Request $request)
    {
    
   if ($request->ajax()) {
    $auth = true;
    if (!Auth::check()) {
             $auth = false;
             } 

        $foodID = $request->foodID;
        $food = Food::findOrFail($foodID);
        $variations = Variation::where('food_id',$foodID)->get();
        $variationExtras = Extra::getVariationExtras($food->id);
        $variationExtraId = Extra::getVariationExtraId($food->id);
        $extras = Extra::where('food_id',$foodID)->whereNotIn('id', $variationExtraId)->get();
        $restaurant = Restaurant::findOrFail($food->restaurant_id);
        $is_open = Helper::isOpen($restaurant->id,Carbon::now());
        $open_at = Helper::getKeyValue('open_at');
        $close_at = Helper::getKeyValue('close_at');
        $isapp_open = Helper::isAppOpen($open_at,$close_at); 

        $food_details = view('restaurant.items.food_details', compact('food','variations','extras'))->render();


        return Response::json([
            'food_details' => $food_details,
            'is_open'=>$is_open,
            'isapp_open' => $isapp_open,
            'auth'=>$auth,
            'food'=>$food
        ]);

    } else  return \Redirect::route('home');

    }
    


//get Product Details in Modal
    public function getExtraVariations(Request $request)
    {
    
   if ($request->ajax()) {
    $variation_id = $request->variation_id;
    $variationExtras = Extra::getVariationExtras($variation_id);
    $this_variation = Variation::findOrFail($request->variation_id);

    $variation_details = view('restaurant.items.variation_extras', compact('variationExtras'))->render();
    return Response::json([
            'variation_details' => $variation_details,
            'this_variation' => $this_variation
        ]);

    } else  return \Redirect::route('home');

    }
    

//get Product Details in Modal
    public function getFoodPrice(Request $request)
    {
    
   if ($request->ajax()) {
    
    $variation_id = $request->variation_id;
    $extraIds = $request->extraIds;
    $extraVariationIds = $request->extraVariationIds;
    $extras_price = 0;
    $extra_variation_price = 0;

    if($variation_id == null)
    {
    $food_price = Food::findOrFail($request->food_id)->price;
    } 

    else {
        $food_price = 0;
    }

  if($variation_id == null)
    {
        $variation_price = 0;
        $extra_variation_price = 0;
    } 

    else 
      {
        $variation = Variation::findOrFail($variation_id);
        $variation_price = $variation->price;
      if($extraVariationIds == null)
        {
         $extra_variation_price = 0;
        } 

        else 
          {
            foreach ($extraVariationIds as $key => $value) {
                 $extra_variation = VariationExtra::findOrFail($value);
                 $extra_variation_price += $extra_variation->price;
               }
           }

      
      }


  if($extraIds == null)
    {
        $extras_price = 0;
    } 

    else 
      {
        foreach ($extraIds as $key => $value) {
             $extra = Extra::findOrFail($value);
             $extras_price += $extra->price;
           }
       }

  if($variation_id == null)
    { 
     $total_price =  $extras_price +  $food_price; 
    } 
    else 
    {  
         $total_price =  $extras_price +  $variation_price + $extra_variation_price; 
    
    }  


    return Response::json([
            'total_price' => $total_price
        ]);

    } 

    else  return \Redirect::route('home');

    }
    


//add Food To Cart
    public function addFoodToCart(Request $request)
    {
    
   if ($request->ajax()) {
    $isEdit = $request->isEdit;
    $variation_id = $request->variation_id;
    $extraIds = $request->extraIds;
    $extraVariationIds = $request->extraVariationIds;
    $food_id = $request->food_id;
    $quantity = $request->quantity;
    $instruction = $request->instruction;
    $food = Food::findOrFail($food_id);
    
    $check_cart = Cart::where('user_id',Auth::user()->id)->first();
    if($check_cart)
   { 

   // old items
       $restaurant_id = $check_cart->food->restaurant->id;
          
          if ($restaurant_id != $food->restaurant->id)
           $check_cart->delete();
   }
   

    if($isEdit != 0)
        {
        try {
               Cart::destroy($isEdit);
             } catch (ModelNotFoundException $e) {
             // Handle the error.
            }
        }
       $cart = Cart::create([
        'food_id' => $food->id, 
        'user_id' => Auth::user()->id ,
        'quantity' => $quantity,
        'instruction' => $instruction
    ]);

   if ($variation_id != null) { 
        $cart->variations()->attach($variation_id);
    }

   if ($extraIds != null) { 
            $cart->extras()->attach($extraIds);
    }

   if ($extraVariationIds != null) { 
            $cart->extra_variations()->attach($extraVariationIds);
    }
         
          $carts = Cart::GetFinal(Auth::user()->id);
          $cart_content = view('cart.cart_content',compact('carts'))->render();
          $cart_badge = view('cart.cart_badge',compact('carts'))->render();

        return Response::json([
            'cart_content' => $cart_content,
            'cart_badge' => $cart_badge
        ]);

    } else  return \Redirect::route('home');

    }
    

  //------------Validate if min Order
    public function ValidateCart()
    {
    
    $carts = Cart::GetFinal(Auth::user()->id);
    if($carts['subtotal'] < $carts['carts']->first()->food->restaurant->min_order)
        $validate = false;
        else $validate = true;

    $url=route('customer_address.index');
        return Response::json([
            'validate' => $validate,
            'url' => $url
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
    try {
           
           Cart::destroy($id);
         
          $carts = Cart::GetFinal(Auth::user()->id);
          $cart_content = view('cart.cart_content',compact('carts'))->render();
          $cart_badge = view('cart.cart_badge',compact('carts'))->render();

        return Response::json([
            'cart_content' => $cart_content,
            'cart_badge' => $cart_badge
        ]);



         } catch (ModelNotFoundException $e) {
         // Handle the error.
        }
     }
}
