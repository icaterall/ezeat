<?php

namespace App\services\Emails;
use Illuminate\Http\Request;
use Facades\App\Helpers\Helper;
use Facades\App\Helpers\SendSMS;
use Facades\App\Models\Cart;
use Facades\App\Models\Order;
use Facades\App\Models\OrderOffer;
use Illuminate\Support\Facades\Config;
use Facades\App\Services\SendEmail;
use Auth;
use Session;
use Response;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderStatusEmail
{

    private $order_email;
    private $cs_email;
    private $admin_email;
    private $url;

    public function __construct()
    {
        $this->order_email = Helper::getKeyValue('order_email');
        $this->admin_email = Helper::getKeyValue('admin_email');
        $this->cs_email = Helper::getKeyValue('cs_email');   
        $this->url = Config::get('app.url'); 
    }

//----------Send first ordering attempt Email

    public function DraftOrder($order_id)
    {     
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;

           //-------- Send to CService
        $order_cservice_url =  $this->url.'/admin_gate/orders/'.$order_id.'/edit';
        $cservice_title = ('Dear Customer Service, Now a customer is trying to order, please follow the order very carefully!');
        SendEmail::SendOrderEmail($order_id, 'Draft Order' , $this->order_email , Null,$order,$order->total,$order_cservice_url,$cservice_title); 
    }


//----------------- No rider accept

     public function noRiderAccept($order_id)
    {     
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;

           //-------- Send to CService
        $order_cservice_url =  $this->url.'/admin_gate/orders/'.$order_id.'/edit';
        $cservice_title = ('Dear Customer Service, No rider accept the order below, please check it!');
        SendEmail::SendOrderEmail($order_id, ' Order has no Rider!' , $this->order_email , Null,$order,$order->total,$order_cservice_url,$cservice_title); 
    }   

//----------Send to CS if merchant accept the order

    public function merchantAccept($order_id)
    {     
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;

           //-------- Send to CService
        $order_cservice_url =  $this->url.'/admin_gate/orders/'.$order_id.'/edit';
        $cservice_title = ('Dear Customer Service, Restaurant has been confirmed the order');
        SendEmail::SendOrderEmail($order_id, 'Order Confirmed' , $this->order_email , Null,$order,$order->total,$order_cservice_url,$cservice_title); 
    }

//----------Send to customer if food is ready

    public function foodIsReady($order_id)
    {     
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;
             //-------- Send to Customer
        $order_customer_url =  $this->url.'/customer/order-placed/'.$restaurant->id.'/'.$order->id;
        $customer_title = ('Dear Customer, Your order is ready to collect');
        SendEmail::SendOrderEmail($order_id, 'Food is ready' , $order->user->email , Null,$order,$order->total,$order_customer_url,$customer_title); 
    }

//----------Send Declined Order Email

    public function declinedOrder($order_id)
    {     
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;

           //-------- Send to CService
        $order_cservice_url =  $this->url.'/admin_gate/orders/'.$order_id.'/edit';
        $cservice_title = ('Dear Customer Service, The order below was canceled, please review it');
        SendEmail::SendOrderEmail($order_id, 'Declined Order' , $this->order_email , Null,$order,$order->total,$order_cservice_url,$cservice_title); 
                       //-------- Send to Customer
        $order_customer_url =  $this->url.'/customer/order-placed/'.$restaurant->id.'/'.$order->id;
        $customer_title = ('Dear Customer, Your order has been successfully canceled');
        SendEmail::SendOrderEmail($order_id, 'Order Canceled' , $order->user->email , Null,$order,$order->total,$order_customer_url,$customer_title); 
    }




//----------Send if faild to order

    public function FaildOrder($order_id)
    {     
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;
           //-------- Send to CService
        $order_cservice_url =  $this->url.'/admin_gate/orders/'.$order_id.'/edit';
        $cservice_title = ('Dear Customer Service, Customer failed to complete the order, please review it!');
        SendEmail::SendOrderEmail($order_id, 'Faild Order' , $this->order_email , Null,$order,$order->total,$order_cservice_url,$cservice_title); 
    }

//----------Send Email if success
    public function OrderEmail($order_id)
    {     

        $order = Order::find($order_id);
        if($order)
         {
          $restaurant = $order->foods->first()->restaurant;
          $order_restaurant_url =  $this->url.'/order_details/'.$order_id.'/'.$order->secret;

         //SendSMS::sendOrderSms($restaurant->mobile,$order_restaurant_url); // send and return its response 

        $restaurant = $order->foods->first()->restaurant;
        
//----------------------- End Rider --------------

               //-------- Send to Customer
        $order_customer_url =  $this->url.'/customer/order-placed/'.$restaurant->id.'/'.$order->id;
        $customer_title = ('Dear Customer, Your order has been successfully received');
        SendEmail::SendOrderEmail($order_id, 'Order Placed' , $order->user->email , Null,$order,$order->total,$order_customer_url,$customer_title); 

               //-------- Send to restaurant
        $order_restaurant_url =  $this->url.'/order_details/'.$order_id.'/'.$order->secret;
        $restaurant_title = ('Dear Restaurant Owner, a customer just ordered from your restaurant, please respond to the order within 5 minutes');
        SendEmail::SendOrderEmail($order_id, ' New order Placed' , $restaurant->email , Null ,$order,$order->restaurant_total,$order_restaurant_url,$restaurant_title); 
    

        $cservice_title = ('Dear Customer Service, a customer just ordered from Spoongate, please check the status of this order');
        SendEmail::SendOrderEmail($order_id, 'Order Placed' , $this->order_email , $this->admin_email,$order,$order->total,$order_restaurant_url,$cservice_title); 
    }


}


}


