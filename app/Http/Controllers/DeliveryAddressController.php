<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Helpers\Helper;
use Facades\App\Helpers\SendSMS;
use Facades\App\Models\DeliveryAddress;
use Facades\App\Models\User;
use Facades\App\Models\Cart;
use Auth;
use Session;
class DeliveryAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('current_url');

        $carts = Cart::GetFinal(Auth::user()->id);
        $address_information = DeliveryAddress::where('user_id',Auth::user()->id)->first();
       
        if (count($carts['carts'])>0) {  
            $restaurant = $carts['carts']->first()->food->restaurant;    
            
            if($carts['subtotal'] < $restaurant->min_order)
            {
            return \Redirect::route('RestaurantMenu',[$restaurant->id,$restaurant->name])->withSuccess('Your order is below the minimum order value of MYR '.$restaurant->min_order.', Please add more items');
            } 
            else {
       return view('customers.delivery_address.archive', compact('carts','address_information'));
            }
        } 
  else 

        {           //If Cart is Empty
            return \Redirect::route('home');
        }

}


// ---------------- Update delivery address information and continue
       
        public function updateAddress(Request $request)
    {
        
        $carts = Cart::GetFinal(Auth::user()->id);
        $address_information = DeliveryAddress::where('user_id',Auth::user()->id)->first();
        Session::put(['order_instruction' => $request->order_instruction]);   
        $address_information['suite_floor'] = $request->suite_floor;
        $user_address = DeliveryAddress::where('user_id', Auth::User()->id)
       ->get();

    $address_information['latitude'] = Session::get('user_lat');
    $address_information['longitude'] =  Session::get('user_long');
    $address_information['is_default'] = $request->set_default;

            DeliveryAddress::updateOrCreate([
                'user_id' => Auth::User()->id,
            ], [
                'address' => $request->address,
                'latitude' => $address_information['latitude'],
                'longitude' => $address_information['longitude'],
                'suite_floor' => $address_information['suite_floor'],
                'is_default' => $address_information['is_default']
                ]);


        $user = User::find(Auth::user()->id);
        $user->update([
            'name' => $request->name,
        ]);
 

     if($request->mobile != $user->mobile) 

      {

        $messages = ['mobile.required' => 'Mobile Number is required.'];
              $validator = \Validator::make($request->all(), [
                          'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10, |unique:users,mobile,'.Auth::user()->id,
                      ], $messages);
                  
              if ($validator->fails()) {
                  return response()->json(['errors' => $validator->errors()->all()]);
              }
     
     $user->update([
            'mobile' => $request->mobile,
            'status' => 0
        ]);

      }

        if($user->status == 0)
       
        {
       
       $code = rand(1000, 9999);

        $user->update([
            'activation_code' => $code
        ]);

        SendSMS::sendUserSms($request->mobile,$code); // send and return its response      
        
        Session::flash('success', 'Please activate your mobile number to continue'); 
        return route('smsverify');
    }

else    // Return to payment page
                {
                return route('checkout_review.index');

                }

    }


 /**
     * Update order instruction from the checkout page.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInstruction(Request $request)
    {
        Session::put(['order_instruction' => $request->order_instruction]);
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
