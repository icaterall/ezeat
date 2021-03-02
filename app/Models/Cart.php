<?php
/**
 * File name: Cart.php
 * Last modified: 2020.06.11 at 16:10:52
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\Models;
use Session;
use Facades\App\Helpers\Helper;
use Facades\App\Models\Coupon;

use Eloquent as Model;

/**
 * Class Cart
 * @package App\Models
 * @version September 4, 2019, 3:38 pm UTC
 *
 * @property \App\Models\Food food
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection extras
 * @property integer food_id
 * @property integer user_id
 * @property integer quantity
 */
class Cart extends Model
{

    public $table = 'carts';
    


    public $fillable = [
        'food_id',
        'user_id',
        'quantity',
        'instruction'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'food_id' => 'integer',
        'user_id' => 'integer',
        'quantity' => 'integer'
    ];


    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'total_item',
        'total_restaurant_item'
    ];




  public function getTotalRestaurantItemAttribute()
    {
      $variation_price = $this->food->restaurant_price;
      $total_extra_price = 0;
      $total_extra_variation_price =0;
      $extraVariationIds = [];

       if(count($this->variations)>0)
       $variation_price = $this->variations->sum('restaurant_price');

     if(count($this->extra_variations)>0)
     {

      
      $total_extra_variation_price = $this->extra_variations->sum('restaurant_price');

      foreach ($this->extra_variations as $key => $extra_variation) {
        $extraVariationIds[] = $extra_variation->extra_id;
      }
   
   }
    
    if(count($this->extras)>0)
     {

       $total_extra_price = $this->extras->whereNotIn('id',$extraVariationIds)->sum('restaurant_price');
        
     }

return number_format(($variation_price + $total_extra_price + $total_extra_variation_price) * $this->quantity , 2, '.', ',');

     }




  public function getTotalItemAttribute()
    {
      $variation_price = $this->food->price;
      $total_extra_price = 0;
      $total_extra_variation_price =0;
      $extraVariationIds = [];

       if(count($this->variations)>0)
       $variation_price = $this->variations->sum('price');

     if(count($this->extra_variations)>0)
     {

      
      $total_extra_variation_price = $this->extra_variations->sum('price');

      foreach ($this->extra_variations as $key => $extra_variation) {
        $extraVariationIds[] = $extra_variation->extra_id;
      }
   
   }
    
    if(count($this->extras)>0)
     {

       $total_extra_price = $this->extras->whereNotIn('id',$extraVariationIds)->sum('price');
        
     }

return number_format(($variation_price + $total_extra_price + $total_extra_variation_price) * $this->quantity , 2, '.', ',');

     }


public function appCart($user_id)
{
     $subtotal = 0;
       $subtotal_restaurant = 0;
       $restaurant_discount = 0;
       $delivery_restaurant_fee = 0;
       $discount_value = 0;
        $data = [];
        $carts = Cart::where('user_id',$user_id)->get();

        foreach ($carts as $key => $cart) {
          $subtotal = $subtotal + $cart['total_item'];
          $subtotal_restaurant = $subtotal_restaurant + $cart['total_restaurant_item'];
        }
        $restaurant = $carts->first()->food->restaurant;
        
        
        if($carts->first()->isdelivery == 1)
         $delivery_fee = $restaurant->delivery_fee;
         else  $delivery_fee = 0;

         if($restaurant->has_riders == 1)
          $delivery_restaurant_fee = $delivery_fee;



        $service_charge = Helper::getKeyValue('service_charge');
        $tax = $restaurant->default_tax;

        $tax_value = ($tax * $subtotal) / 100;
        $tax_restaurant_value = ($tax * $subtotal_restaurant) / 100;


        $code = null;
      if($carts->first()->coupon_id != null)
      
      { 
        $discount = Coupon::find($carts->first()->coupon_id);
       if($discount)
       {


        $code = $discount->code;
            if($discount->discount_type == 'percent')
            {
              $discount_value = ($discount->discount * $subtotal) / 100;
            }
             else $discount_value = $discount->discount;
      
      } 

       if($discount->restaurant_id != null)
              {
                $restaurant_discount = $discount_value;
              }
      }



    $total = $subtotal + ($discount_value * - 1.00) + $service_charge + $tax_value + $delivery_fee;
    $restaurant_total = $subtotal_restaurant + ($restaurant_discount * - 1.00) + $tax_restaurant_value + $delivery_restaurant_fee;


    return $data = [
            'subtotal' =>number_format($subtotal , 2, '.', ','),
            'subtotal_restaurant' =>number_format($subtotal_restaurant , 2, '.', ','),
            'discount' => number_format($discount_value * -1 , 2, '.', ',') ,
            'delivery_restaurant_fee' => number_format($delivery_restaurant_fee , 2, '.', ',') ,
            'service_charge' =>number_format($service_charge, 2, '.', ',') ,
            'tax_percent' =>number_format($tax, 2, '.', ',') ,
            'tax_value' =>number_format($tax_value, 2, '.', ',') ,
            'tax_restaurant_value' =>number_format($tax_restaurant_value, 2, '.', ',') ,
            'delivery_fee' =>number_format($delivery_fee, 2, '.', ',') ,
            'total' =>number_format($total, 2, '.', ',') ,
            'restaurant_total' => number_format($restaurant_total, 2, '.', ',') ,
            'order_type' => $carts->first()->order_type,
            'date' => $carts->first()->date,
            'time' => $carts->first()->time,
            'isdelivery' => $carts->first()->isdelivery,
            'discount_restaurant'  => number_format($restaurant_discount, 2, '.', ',') ,
            'code' => $code
         ];

}



    public function GetAppFinalCart($user_id)
    {
    
    $cart_amount = $this->appCart($user_id);

     $service_charge = Helper::getKeyValue('service_charge');
     $subtotal = 0;
     $subtotal_restaurant = 0;

        $carts = $this
            ->where('user_id','=',$user_id)
            ->orderBy('id', 'DESC')
            ->get();
     

     $items = [];
     $food_extras = [];
     if(count($carts)>0)    
    {
   
//--------------------Fixed ---------------
          $tip = 0;
          $restaurant_tip = 0;
          $discount_restaurant = 0;
          $discount = 0;
          $delivery_fee = $cart_amount['delivery_fee'];
          $delivery_fee_restaurant = 0;

          if($carts->first()->food->restaurant->has_riders == 0)
          {
            $delivery_fee_restaurant = 0;
          } else $delivery_fee_restaurant = $cart_amount['delivery_fee'];

         
         if($cart_amount['discount'] > 0)
          $discount = $cart_amount['discount'];

         $coupon = Coupon::where('code',$cart_amount['code'])->first();
          if($coupon != null)
          {
            if($coupon->restaurant_id == null)
              $discount_restaurant = 0;
            else $discount_restaurant = $coupon->discount;
          }


        $service_fee = $carts->first()->food->restaurant->default_tax;
        $service_charge = number_format($service_charge, 2, '.', ',');
        $food_truck = $carts->first()->food->restaurant->food_truck;


//---------------------End Fixed
  foreach ($carts as $key => $cart) {
        
        $total_extra_price = $cart->extras->sum('price');
        $food_price = $cart->variations->sum('price');
        $food_size = null;
        $total_extra_variation_price = $cart->extra_variations->sum('price');
        
        if($cart->variations->sum('price') == 0)
        {
         $food_price = $cart->food->price;
        }     
     if(count($cart->variations) > 0)
     $food_size = $cart->variations->first()->name;


        $total_price = $total_extra_price + $food_price + $total_extra_variation_price;
        $total_price = $total_price * $cart->quantity;

    //---------Restaurant Price   
    $total_extra_price_restaurant = $cart->extras->sum('restaurant_price');
    $food_price_restaurant = $cart->variations->sum('restaurant_price');
    $total_extra_variation_price_restaurant = $cart->extra_variations->sum('restaurant_price');
    
    if($cart->variations->sum('restaurant_price') == 0)
        {
         $food_price_restaurant = $cart->food->restaurant_price;
        }
        $total_price_restaurant = $total_extra_price_restaurant + $food_price_restaurant + $total_extra_variation_price_restaurant;
        $total_price_restaurant = $total_price_restaurant * $cart->quantity;
        $subtotal += $total_price;
        $subtotal_restaurant += $total_price_restaurant;


array_push($items,[   
    'cart_id' => $cart->id, 
    'food_name' => $cart->food->name,
    'food_id' => $cart->food->id,
    'quantity' => $cart->quantity,
    'food_size' => $food_size,
    'total_price' => $total_price,
    'food_instruction' => $cart->instruction,
    'total_price_restaurant' => $total_price_restaurant,
    'food_price' => $food_price,
    'food_price_restaurant' => $food_price_restaurant
      ]);
    }
           
  $service_fee_value = ($service_fee * $subtotal) / 100;       
  $discount_value = $discount;       
  $subtotal_tax = $subtotal + $service_fee_value - $discount_value;
  $total_cart = number_format($subtotal_tax + $delivery_fee  + $tip + $service_charge, 2, '.', ',');

//------Restaurant -------------

        $service_fee_value_restaurant = ($service_fee * $subtotal_restaurant) / 100;
        $discount_value_restaurant = $discount_restaurant;

        $subtotal_tax_restaurant = $subtotal_restaurant + $service_fee_value_restaurant - $discount_value_restaurant;

        $total_cart = number_format($subtotal_tax + $delivery_fee  + $tip + $service_charge, 2, '.', ',');
        
        $total_cart_restaurant = number_format($subtotal_tax_restaurant + $delivery_fee_restaurant  + $restaurant_tip, 2, '.', ',');

       return array(
                    'subtotal'   => $subtotal,
                    'total_cart' => $total_cart,
                    'service_fee'   => $service_fee,
                    'delivery_fee'   => $delivery_fee,
                    'total_price' => $total_price,
                    'service_fee_value'   => $service_fee_value,
                    'discount_value'   => $discount_value,
                    'subtotal_tax'   => $subtotal_tax,

//------------------------Restaurant---------Price
                    'subtotal_restaurant'   => $subtotal_restaurant,
                    'total_cart_restaurant' => $total_cart_restaurant,
                    'delivery_fee_restaurant'   => $delivery_fee_restaurant,
                    'total_price_restaurant' => $total_price_restaurant,
                    'service_fee_value_restaurant'   => $service_fee_value_restaurant,
                    'discount_value_restaurant'   => $discount_value_restaurant,
                    'subtotal_tax_restaurant'   => $subtotal_tax_restaurant,
//------------------------------------------------------------------------------
                    'service_charge'   => $service_charge,
                   
                    'discount'   => $discount, 
                    'tip'   => $tip,
                    'food_truck'   => $food_truck,
                    'carts'   => $carts,
                    'items' => $items
                   );
       
       } else return 
                 array(
                    'carts'   => $carts
                   );

    }




    public function GetFinal($user_id)
    {
     $service_charge = Helper::getKeyValue('service_charge');
     $subtotal = 0;
     $subtotal_restaurant = 0;

        $carts = $this
            ->where('user_id','=',$user_id)
            ->orderBy('id', 'DESC')
            ->get();
     

     $items = [];
     $food_extras = [];
     if(count($carts)>0)    
    {
   
//--------------------Fixed ---------------
          $tip = 0;
          $tip = Session::get('tipamount');
          $tip = preg_replace("/[^0-9.]/", "", $tip);
          if(($tip == null) or ($tip == ''))
          $tip = 0;
         if(Session::get('discount') == null)
          $discount = 0;
          $discount_restaurant = 0;
          $restaurant_tip = $tip;
          $discount = Session::get('discount');
          $discount_type = Session::get('discount_type');
          $order_type = Session::get('order_type');
          
          
          if(Session::get('restaurant_promo') == $carts->first()->food->restaurant->id)
          $discount_restaurant = $discount;
        

if( $carts->first()->food->restaurant->available_for_delivery == false)
    $order_type = 'pickup';

if( $carts->first()->food->restaurant->available_for_pickup == false)
              $order_type = 'delivery';







        if( $order_type == null OR $order_type == 'delivery')
        {    
            $order_type = 'delivery';
            $delivery_fee = $carts->first()->food->restaurant->delivery_fee;
            if($carts->first()->food->restaurant->has_riders == 1) 
            {
               $delivery_fee_restaurant = $carts->first()->food->restaurant->delivery_fee; 
            }  
            else{
                $delivery_fee_restaurant = 0;
            }     
        } 
        else
           {
            $order_type = 'pickup';
            $delivery_fee = 0;
            $delivery_fee_restaurant = 0;
          }
        if($carts->first()->food->restaurant->food_truck == 1)
        {
          $delivery_fee = 0;
          $delivery_fee_restaurant = 0;  
        }
        $service_fee = $carts->first()->food->restaurant->default_tax;
        $service_charge = number_format($service_charge, 2, '.', ',');
        $food_truck = $carts->first()->food->restaurant->food_truck;

        if(($carts->first()->food->restaurant->has_riders == 0) AND $order_type == 'delivery')
          $restaurant_tip = 0;



//---------------------End Fixed
  foreach ($carts as $key => $cart) {
        
        $total_extra_price = $cart->extras->sum('price');
        $food_price = $cart->variations->sum('price');
        $food_size = null;
        $total_extra_variation_price = $cart->extra_variations->sum('price');
        
        if($cart->variations->sum('price') == 0)
        {
         $food_price = $cart->food->price;
        }     
     if(count($cart->variations) > 0)
     $food_size = $cart->variations->first()->name;


        $total_price = $total_extra_price + $food_price + $total_extra_variation_price;
        $total_price = $total_price * $cart->quantity;

    //---------Restaurant Price   
    $total_extra_price_restaurant = $cart->extras->sum('restaurant_price');
    $food_price_restaurant = $cart->variations->sum('restaurant_price');
    $total_extra_variation_price_restaurant = $cart->extra_variations->sum('restaurant_price');
    
    if($cart->variations->sum('restaurant_price') == 0)
        {
         $food_price_restaurant = $cart->food->restaurant_price;
        }
        $total_price_restaurant = $total_extra_price_restaurant + $food_price_restaurant + $total_extra_variation_price_restaurant;
        $total_price_restaurant = $total_price_restaurant * $cart->quantity;
        $subtotal += $total_price;
        $subtotal_restaurant += $total_price_restaurant;


array_push($items,[   
    'cart_id' => $cart->id, 
    'food_name' => $cart->food->name,
    'food_id' => $cart->food->id,
    'quantity' => $cart->quantity,
    'food_size' => $food_size,
    'total_price' => $total_price,
    'food_instruction' => $cart->instruction,
    'total_price_restaurant' => $total_price_restaurant,
    'food_price' => $food_price,
    'food_price_restaurant' => $food_price_restaurant
      ]);
    }
           
        $service_fee_value = ($service_fee * $subtotal) / 100;
        if($discount_type == 'percent')
        $discount_value = ($discount * $subtotal) / 100;
       else $discount_value = $discount;
        
        $subtotal_tax = $subtotal +$service_fee_value - $discount_value;

        $total_cart = number_format($subtotal_tax + $delivery_fee  + $tip + $service_charge, 2, '.', ',');

//------Restaurant -------------

        $service_fee_value_restaurant = ($service_fee * $subtotal_restaurant) / 100;
        
        $discount_value_restaurant = ($discount_restaurant * $subtotal_restaurant) / 100;
        
        $subtotal_tax_restaurant = $subtotal_restaurant + $service_fee_value_restaurant - $discount_value_restaurant;

        $total_cart = number_format($subtotal_tax + $delivery_fee  + $tip + $service_charge, 2, '.', ',');
        
        $total_cart_restaurant = number_format($subtotal_tax_restaurant + $delivery_fee_restaurant  + $restaurant_tip, 2, '.', ',');

       return array(
                    'subtotal'   => $subtotal,
                    'total_cart' => $total_cart,
                    'service_fee'   => $service_fee,
                    'delivery_fee'   => $delivery_fee,
                    'total_price' => $total_price,
                    'service_fee_value'   => $service_fee_value,
                    'discount_value'   => $discount_value,
                    'subtotal_tax'   => $subtotal_tax,

//------------------------Restaurant---------Price
                    'subtotal_restaurant'   => $subtotal_restaurant,
                    'total_cart_restaurant' => $total_cart_restaurant,
                    'delivery_fee_restaurant'   => $delivery_fee_restaurant,
                    'total_price_restaurant' => $total_price_restaurant,
                    'service_fee_value_restaurant'   => $service_fee_value_restaurant,
                    'discount_value_restaurant'   => $discount_value_restaurant,
                    'subtotal_tax_restaurant'   => $subtotal_tax_restaurant,
//------------------------------------------------------------------------------
                    'service_charge'   => $service_charge,
                    'order_type'   => $order_type,
                    'discount'   => $discount, 
                    'tip'   => $tip,
                    'food_truck'   => $food_truck,
                    'carts'   => $carts,
                    'items' => $items
                   );
       
       } else return 
                 array(
                    'carts'   => $carts
                   );

    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function food()
    {
        return $this->belongsTo(\App\Models\Food::class, 'food_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function extras()
    {
        return $this->belongsToMany(\App\Models\Extra::class, 'cart_extras');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function variations()
    {
        return $this->belongsToMany(\App\Models\Variation::class, 'cart_variations');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function extra_variations()
    {
        return $this->belongsToMany(\App\Models\VariationExtra::class, 'cart_variation_extras');
    }

}
