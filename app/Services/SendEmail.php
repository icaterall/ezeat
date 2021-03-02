<?php

namespace App\services;

use Facades\App\Models\User;
use Facades\App\Models\DeliveryAddress;
use Facades\App\Models\Order;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Facades\App\Helper\SendSMS;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use PDF;
use Route;

class SendEmail
{
    
              //Send Order Email
    public function SendOrderEmail($order_id, $order_status, $send_to, $cc_email ,$order,$total_payment,$order_url,$email_title)
    {    
       $send_from = Helper::getKeyValue('send_from');
       $url = Config::get('app.url');
        $order = Order::find($order_id);
        $mailData = [
            'order_id' => $order_id,
            'order_status' => $order_status,
            'total_payment' => $total_payment,
            'order_url' => $order_url,
            'url' => $url,
            'email_title' =>$email_title,
            'order' => $order
        ];
        try {
                Mail::send('include.emails.order_action' , $mailData, function ($message) use ($order_id, $order_status,$send_to, $cc_email ,$send_from) {
                    $message->from($send_from);
                    
                   if($cc_email != null) 
                    {
                        $message->to($send_to)
                        ->cc([$cc_email])
                         ->subject('SpoonGate ::'.$order_status.' --Order #'.$order_id);
                     } else
                     {
                      $message->to($send_to)
                       ->subject('SpoonGate ::'.$order_status.' --Order #'.$order_id);  
                     }
                });
                $response = [
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                ];
            } catch (\Exception $e) {
                // Log all  errors
                \Log::info($e);
                $response['status'] = 'error';
                $response['code'] = $e->getCode();
                $response['message'] = $e->getMessage();
               
            }
    }







//------------------------ Send to Restaurant


              //Send Order Email
    public function SendRestaurantEmail($restaurant,$user,$send_to, $cc_email)
    {    
       $send_from = Helper::getKeyValue('send_from');

        $mailData = [
            'user' => $user,
            'restaurant' => $restaurant
        ];
        try {
                Mail::send('include.emails.restaurant_action' , $mailData, function ($message) use ($user, $restaurant,$send_to, $cc_email ,$send_from) {
                    $message->from($send_from);
                    
                   if($cc_email != null) 
                    {
                        $message->to($send_to)
                        ->cc([$cc_email])
                         ->subject('SpoonGate ::A new restaurant has been registered');
                     } else
                     {
                      $message->to($send_to)
                       ->subject('SpoonGate ::A new restaurant has been registered');  
                     }
                });
                $response = [
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                ];
            } catch (\Exception $e) {
                // Log all  errors
                \Log::info($e);
                $response['status'] = 'error';
                $response['code'] = $e->getCode();
                $response['message'] = $e->getMessage();
               
            }
    }





//-------------------OLD Functions






    //Send Emails
    public function SendStatusEmail($order_number, $orderstatus, $customeremail)
    {
        
        
        $url = Config::get('app.url');
        $setting = SiteSetting::getSettings();
        $send_from = $setting->sender;
        $user = User::where('email', $customeremail)->first();
        $user_id = $user->id;

        $HAuser = HouseAccount::where('user_id', $user_id)->first();
        $orderinfo = Userorder::where('order_number', $order_number)->first();
        $storeinfo = Storeinfo::findOrFail($orderinfo->storeinfo_id);
        $store_name = $storeinfo->store_name;
        $store_fax = $storeinfo->store_fax;
        $store_mobile = $storeinfo->store_mobile;
        $cs_mobile = $setting->hq_fax;
        
        $date=Carbon::now();

        if ('delivery' == $orderinfo->isdelivery) {
            $order_type = 'Delivery';
            $full_address = UserdeliveryAddress::where('order_number', $order_number)->first();

            $order_address = $full_address->st_address.','.$full_address->order_zipcode.','.$full_address->order_city;
        } else {
            $order_type = 'Pickup';
            $order_address = $orderinfo->user_address;
        }
        //get pdf link

        $mailData = [
            'order_number' => $order_number,
            'orderdate' => $orderinfo->order_date,
            'ordertime' => $orderinfo->order_time,
            'secret' => $orderinfo->secret,
            'store_id' => $storeinfo->id,
            'order_status' => $orderinfo->confirmed,
            'store_name' => $storeinfo->store_name,
            'user_distance' => $orderinfo->user_distance,
            'orderstatus' => $orderstatus,
            'order_address' => $order_address,
            'order_type' => $order_type,
            'customer_name' => $user->fname.' '.$user->lname,
            'totalpayment' => $orderinfo->totalpayment,
            'url' => $url,
        ];

            //Customer Service Email
            try {
                Mail::send('include.manager_email', $mailData, function ($message) use ($setting,$send_from, $order_number, $store_name, $orderstatus) {
                    $message->from($send_from);
                    $message->to($setting->contact_email)
                        ->cc([$setting->bcc_email])
                        ->subject('SpoonGate :'.$orderstatus.' Order #'.$order_number.' Store:'.$store_name.'- Order:  ');
                });

                $response = [
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                ];
            } catch (\Exception $e) {
                // Log all  errors
                \Log::info($e);
                $response['status'] = 'error';
                $response['code'] = $e->getCode();
                $response['message'] = $e->getMessage();
            }
    if (Route::currentRouteName()!='storeorder_cr_status')
{
            //Custmer  Email
            try {
                Mail::send('include.user_order_email', $mailData, function ($message) use ($customeremail,$send_from, $order_number, $store_name, $orderstatus) {
                    $message->from($send_from);
                    $message->to($customeremail)
                        ->subject('SpoonGate ::'.$orderstatus.' Order #'.$order_number.' Store:'.$store_name.'- Order:  ');
                });

                $response = [
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                ];
            } catch (\Exception $e) {
                // Log all  errors
                \Log::info($e);
                $response['status'] = 'error';
                $response['code'] = $e->getCode();
                $response['message'] = $e->getMessage();
            }

            /*Caterer Email */
            try {
 
 $link='https://spoongate.com/restaurant_order_details/'.$storeinfo->id.'/'.$order_number.'/'.$orderinfo->secret;
       
         if(config('app.env') == 'production')
           {       
               SendSMS::sendOrderSms($store_mobile,$link); // send and return its response        
               SendSMS::sendOrderSms($cs_mobile,$link); // send and return its response
           }
        
                Mail::send('include.caterer_email', $mailData, function ($message) use ($storeinfo,$send_from, $order_number,$orderstatus) {
                    $message->from($send_from);
                    $message->to($storeinfo->store_email)
                        ->cc([$storeinfo->store_cc_email])
                        ->subject('SpoonGate -'.$orderstatus.' Order #'.$order_number);
                });

                $response = [
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                ];
            



            } catch (\Exception $e) {
                // Log all  errors
                \Log::info($e);
                $response['status'] = 'error';
                $response['code'] = $e->getCode();
                $response['message'] = $e->getMessage();
            }

        }
    }

    //Reject HA Order
    public function SendRejectHAemail($order_number, $orderstatus, $customeremail)
    {
        $url = Config::get('app.url');
        $setting = SiteSetting::getSettings();
        $user_id = User::where('email', $customeremail)->first()->id;
        $send_from = $setting->sender;

        $HAuser = HouseAccount::where('user_id', $user_id)->first();
        $orderinfo = Userorder::where('order_number', $order_number)->get()->first();
        $storeinfo = Storeinfo::findOrFail($orderinfo->storeinfo_id);
        $store_name = $storeinfo->store_name;

        $mailData = [
            'order_number' => $order_number,
            'orderdate' => $orderinfo->order_date,
            'ordertime' => $orderinfo->order_time,
            'store_name' => $storeinfo->store_name,
            'user_distance' => $orderinfo->user_distance,
            'orderstatus' => $orderstatus,
            'order_address' => $orderinfo->user_address,
            'url' => $url,
        ];

        //Customer  Email
        try {
            Mail::send('include.user_order_email', $mailData,
                function ($message) use ($customeremail,$send_from, $order_number, $store_name, $orderstatus) {
                    $message->from($send_from);
                    $message->to($customeremail)
                        ->subject('SpoonGate ::'.$orderstatus.' Order #'.$order_number.' Store:'.$store_name.'- Order:  ');
                });

            $response = [
                'status' => 'success',
                'msg' => 'Mail sent successfully',
            ];
        } catch (\Exception $e) {
            // Log all  errors
            \Log::info($e);
            $response['status'] = 'error';
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
        }
    }





}
