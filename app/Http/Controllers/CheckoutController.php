<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Helpers\Helper;
use Facades\App\Helpers\SendSMS;
use Facades\App\Models\DeliveryAddress;
use Facades\App\Models\User;
use Facades\App\Models\Cart;
use Facades\App\Models\Order;
use Facades\App\Services\Payment\SaveOrderToCart;
use Facades\App\Services\Payment\KipleOnlineBanking;

use Facades\App\Services\Emails\OrderStatusEmail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrder;
use Illuminate\Support\Facades\Config;
use Facades\App\Models\OrderOffer;
use App\Jobs\sendNewOrderEmail;
use Facades\App\Models\OrderUser;
use Auth;
use Session;
use Response;
use Carbon\Carbon;
use Redirect;
class CheckoutController extends Controller
{

//-------------------------------------------Payments --------
//--------------------          Online Banking payment       ----------------------------

   public function OnlinePay(Request $request)
    {

        $carts = Cart::GetFinal(Auth::user()->id);
        $amount = number_format($carts['total_cart'], 2, '.', ',');
        $payment_code = $request->payment_code;
        $isApp = false;
        $returnURL = route('PaymentStatus');
        $payment = KipleOnlineBanking::OnlineKiplePayBanking($amount,$payment_code,Auth::user()->id ,$returnURL,$isApp);


     }


   public function AppOnlinePay(Request $request)
    {

        $payment_code = $request->payment_code;
        $amount = number_format(Cart::appCart($request->user_id)['total'], 2, '.', ',');
         $returnURL = route('AppPaymentStatus');
         $isApp = true;
        $payment = KipleOnlineBanking::OnlineKiplePayBanking($amount,$payment_code,$request->user_id,$returnURL,$isApp);
    }


//-------App checkout

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function appCheckout($user_id,Request $request)
    {
        session()->forget('address_id');
        $order_mode = $request->order_mode;
        $address_id = $request->delivery_address_id;
        Session::put(['address_id' => $request->delivery_address_id]);
        $cart = Cart::where('user_id',$user_id)->get();
        if($order_mode == 1)
            $order_mode = 1;
        else $order_mode = 0;
        if(count($cart)>0)
         Cart::where('user_id',$user_id)->update(['isdelivery' => $order_mode]);

        if(count($cart)>0)
        return view('customers.checkout.app_kiple_online_banking',compact('user_id','cart'));
        else return 'Something went Error';
    }




   public function successPayment(Request $request)
    {
    session()->forget('address_id');

    }



//--------------------          Cash payment       ----------------------------

   public function CashPay(Request $request)
    {
        $carts = Cart::GetFinal(Auth::user()->id);
        $restaurant = $carts['carts']->first()->food->restaurant; 
   
        if($restaurant->accept_cash == 1)   
            {
                
                $order_id = $this->cashPayment(Auth::user()->id);
                return \Redirect::route('placedOrder', [$restaurant->id,$order_id]);
            }
            else
                {
                  return \Redirect::route('checkout_review.index')->withSuccess('You cannot use cash for this order');
                }
     }



public function cashPayment($user_id)
{

       $order = OrderUser::where('user_id',$user_id)->first();

       if($order != null)
         {
            try {
             Order::destroy($order->order_id);
             }    catch (ModelNotFoundException $e) {
             // Handle the error.
           }
         }
                $order_id = SaveOrderToCart::SaveToOrders(1,$user_id);
                $order = Order::find($order_id);
                Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));
                 dispatch(new sendNewOrderEmail($order_id))->delay(now()->addSeconds(3));
                  $restaurant = $order->foods->first()->restaurant;

                if(($order->isdelivery == 1) AND ($restaurant->has_riders == 0))   
                           {
                            $this->SaveToRider($orderid);
                          }
                 
                SaveOrderToCart::Destroy_cart($user_id);
                $order = Order::find($order_id);
                return $order_id;
}




///----------------- Status for Web

 public function PaymentStatus(Request $request)
    {   session()->forget('address_id');
        $cross_chk_hash = "";
        $prm_mrhsKey    =  config('services.kiple.ApiKey');//get from gloabl constant or glovbal var
        $prm_mrhid      =  config('services.kiple.username');//get from gloabl constant or glovbal var
       $orderid = $_POST['ord_mercref'];
  
        if(!empty($_POST['ord_mercref']) && !empty($_POST['ord_totalamt'])){
            //check hashvalue
            $cross_chk_hash = sha1($prm_mrhsKey . $prm_mrhid . $_POST['ord_mercref'] . str_replace('.', '', $_POST['ord_totalamt']).$_POST['returncode']);

                    if($_POST['returncode'] == 100){
                      
                $order = Order::find($orderid);
                if($order)
                { 
                  if($order->payment_status != 1)
                 {
                        $order->update(['payment_status' => 1]);
                        dispatch(new sendNewOrderEmail($orderid))->delay(now()->addSeconds(3));
                        Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));
                         $restaurant = $order->foods->first()->restaurant;
                        if(($order->isdelivery == 1) AND ($restaurant->has_riders == 0))   
                           {
                            $this->SaveToRider($orderid);
                          }

                        SaveOrderToCart::Destroy_cart($order->user_id);
                       
                        return \Redirect::route('placedOrder', [$restaurant->id,$orderid]);

                    }  else return response()->json(['data' => 'success'], 200);       
                    
                 }
                    }
                    else
                    {
                            if($_POST['returncode'] == "E2"){
                                 return Redirect::to('checkout/checkout_payment/checkout_review')->withSuccesss('The transaction was cancelled');
                               }
                               else
                               {
                     return Redirect::to('checkout/checkout_payment/checkout_review')->withSuccess('Something went error, please try again');
                               }

                    }

        }else{
            return Redirect::to('checkout/checkout_payment/checkout_review')->withSuccess('Payment parameters are missing.');
        }

     }   





//kiple App ------------------------

 public function AppPaymentStatus(Request $request)
    {   session()->forget('address_id');
        $cross_chk_hash = "";
        $prm_mrhsKey    =  config('services.kiple.ApiKey');//get from gloabl constant or glovbal var
        $prm_mrhid      =  config('services.kiple.username');//get from gloabl constant or glovbal var
       $orderid = $_POST['ord_mercref'];
  
        if(!empty($_POST['ord_mercref']) && !empty($_POST['ord_totalamt'])){
            //check hashvalue
            $cross_chk_hash = sha1($prm_mrhsKey . $prm_mrhid . $_POST['ord_mercref'] . str_replace('.', '', $_POST['ord_totalamt']).$_POST['returncode']);

                    if($_POST['returncode'] == 100){

               
                $order = Order::find($orderid);

                 if($order->payment_status != 1)
               {
                

                $order->update(['payment_status' => 1]);
               
                dispatch(new sendNewOrderEmail($orderid))->delay(now()->addSeconds(3));

                Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));
                $restaurant = $order->foods->first()->restaurant;

                        if(($order->isdelivery == 1) AND ($restaurant->has_riders == 0))   
                           {
                            $this->SaveToRider($orderid);
                          }

                SaveOrderToCart::Destroy_cart($order->user_id);

               
                return \Redirect::route('checkout.success', [$orderid]);

                 }  else return response()->json(['data' => 'success'], 200);
                   

                    }
                    else
                    {
                            if($_POST['returncode'] == "E2"){
                                 return 'The transaction was cancelled';
                               }
                               else
                               {
                     return 'Something went error, please try again';
                               }

                    }

        }else{
            return 'Payment parameters are missing.';
        }

     }   






//-------------- Notification url
 public function NotificationURL(Request $request)
    {

        $cross_chk_hash = "";
        $prm_mrhsKey    =  config('services.kiple.ApiKey');//get from gloabl constant or glovbal var
        $prm_mrhid      =  config('services.kiple.username');//get from gloabl constant or glovbal var
      
      if(isset($_POST['ord_mercref'])) 
      {
        $orderid = $_POST['ord_mercref'];
  
        if(!empty($_POST['ord_mercref']) && !empty($_POST['ord_totalamt'])){
            //check hashvalue
            $cross_chk_hash = sha1($prm_mrhsKey . $prm_mrhid . $_POST['ord_mercref'] . str_replace('.', '', $_POST['ord_totalamt']).$_POST['returncode']);

                    if($_POST['returncode'] == 100){
                      
                $order = Order::find($orderid);
                
               if($order->payment_status != 1)
               {
             
                dispatch(new sendNewOrderEmail($orderid))->delay(now()->addSeconds(1));

                Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));
                 $restaurant = $order->foods->first()->restaurant;
             if(($order->isdelivery == 1) AND ($restaurant->has_riders == 0))   
                           {
                            $this->SaveToRider($orderid);
                          }

                SaveOrderToCart::Destroy_cart($order->user_id);

               

                $order->update(['payment_status' => 1]);

                return \Redirect::route('placedOrder', [$restaurant->id,$orderid]);
            } 

            else return response()->json(['data' => 'success'], 200);
                   
                }
                    else
                   
                    {
                            if($_POST['returncode'] == "E2"){
                                 return 'The transaction was cancelled';
                               }
                               else
                               {
                     return 'Something went error, please try again';
                               }

                    }

        }else{
            return 'Payment parameters are missing.';
        }
    } else return response()->json(['data' => 'success'], 200);

     }   





//-------------------- Save to Rider----------------
public function SaveToRider($order_id)
{
        $order_json = Helper::GetOrderInArray($order_id);
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;
        $order_info = ['data' =>$order_json];
        $json = json_encode($order_info,true);     
     
      if(($order->isdelivery == 1) AND ($restaurant->has_riders == 0))   
       {
        OrderOffer::create([
            'order_number' => $order_id,
            'status' => 'pending',
            'status_note' => 'Pending',
            'data' => $json,
        ]);
      }

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
      {
        session()->forget('current_url');
        $now = Carbon::now();
        $day_id = $now->format('N');
        $today_date = $now->format('Y-m-d');

        $carts = Cart::GetFinal(Auth::user()->id);

        $address_information = DeliveryAddress::where('user_id',Auth::user()->id)->first();
        if (count($carts['carts'])>0) {  
        $restaurant = $carts['carts']->first()->food->restaurant; 
        if($restaurant->active == 0)
        Redirect::route('customer_address.index')->withSuccess('You can not complete this order, restaurant is not available')->send();   
            
            if($carts['subtotal'] < $restaurant->min_order)
            {
            return \Redirect::route('RestaurantMenu',[$restaurant->id,$restaurant->name])->withSuccess('Your order is below the minimum order value of MYR '.$restaurant->min_order.', Please add more items');
            } 
            else {
       return view('customers.checkout.archive', compact('carts','address_information'));
            }
        } 
  else 
        {           //If Cart is Empty
            return \Redirect::route('home');
        }
    }



/*---------------------TIPS ----------------------*/
    public function tips(Request $request)
    {
        Session::put(['tipamount' => $request->tipamount]);
        Session::put(['tip_percent' => $request->tip_percent]);
        $tip_percent = session()->get('tip_percent');  
        $carts = Cart::GetFinal(Auth::user()->id);
        $checkout_cart = view('cart.desktop_cart_summary', compact('carts'))->render();
        $checkout_cart_mobile = view('cart.mobile_cart_summary', compact('carts'))->render();
        return Response::json([
            'checkout_cart' =>$checkout_cart,
            'checkout_cart_mobile' =>$checkout_cart_mobile,
        ]);
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
