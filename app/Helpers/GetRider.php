<?php

namespace App\Helpers;

use Carbon\Carbon;
use Facades\App\Models\CatererUser;
use Facades\App\Models\Storeinfo;
use Facades\App\Models\OrderOffer;
use Facades\App\Models\Rider;
use Facades\App\Models\RiderHistory;
use Facades\App\Models\Userorder;
use Facades\App\Models\Order;
use App\Models\SiteSetting;
use Facades\App\Helper\SendSMS;
use GuzzleHttp\Client;
use Facades\App\Services\Emails\OrderStatusEmail;

use Session;
use Response;
use Str;
use DateTime;
use DateTimeImmutable;
use DatePeriod;
use DateInterval;

class GetRider
{
    /**
     * @return array
     */
  

  public function CheckIfRiderHasNotification($order_id,$distance,$limit)
 {
                       $uuid = 0;
                       $now = Carbon::now();
                       $rider_offer = OrderOffer::where('order_number',$order_id)->first();
                       $order = Order::find($order_id);
                       $restaurant = $order->foods->first()->restaurant;
                       $lat = $restaurant->latitude;
                       $long = $restaurant->longitude;
                        $offers = OrderOffer::where('order_number',$order_id)->first();
                        $riders = $this->findRider($lat,$long,$distance,$limit);

if($rider_offer)
{
                if($rider_offer->status == 'pending')
                 {
                   if($riders)
                 
                     {
                       {  
                        foreach ($riders as $riders['data']) {   
                              if($riders['data'] != null)
                              {  

                              $i = 0;
                              $len = count($riders['data']);

                              
                              foreach ($riders['data'] as $key => $rider) {

                                $uuid = $rider['rider']['data']['uuid'];
                                $rider = Rider::where('uuid',$uuid)->first(); 
                               
                               //Check if order was send to this rider
                              if($rider)
                                {
                                  
                          //Check if the previous rider got notification in 30 second
                            
                            $check_rider_state = RiderHistory::where('order_number',$order_id)
                                ->where('status','pending')
                                ->first();


                            
                       if($check_rider_state) //if it was sent to the previous rider, Check if the time was enough for him to see the notification
                          {  
                            if($now->diffInSeconds($check_rider_state->created_at) > 30)
                              // Go and send to the next rider
                             {

                              $check_rider_state->update(['status' => 'ignore']);

                              $rider_history = RiderHistory::where('order_number',$order_id)
                                ->where('rider_id',$rider->id)
                                ->first(); 

                                if(!$rider_history) //rider didn't recive any notification
                                        {        
                                          RiderHistory::create([
                                              'order_offer_id' => $offers->id,
                                              'order_number' => $order_id,
                                              'status' => 'pending',
                                              'rider_id' => $rider->id
                                          ]);
                                 $this->SendNotificationToRider($order_id,$uuid); // Send to this rider  
                                           break;
                                        }
 
                              } 

                          } 
                          
                          else  // first time to send to all riders, or previous rider igonred the order

                          {

                                  
                                $rider_history = RiderHistory::where('order_number',$order_id)
                                ->where('rider_id',$rider->id)
                                ->first(); 

                               
                                if(!$rider_history) //rider didn't recive any notification

                                        {     
                                          RiderHistory::create([
                                              'order_offer_id' => $offers->id,
                                              'order_number' => $order_id,
                                              'status' => 'pending',
                                              'rider_id' => $rider->id
                                          ]);
                                 $this->SendNotificationToRider($order_id,$uuid); // Send to this rider  
                                           break;
                                        } 

                                   }             
                              } 

                              if ($i == $len - 1) {
                                     
                                     $order_status = Order::find($order_id);
                                     $order_status->update(['job_execute'=>1]);
                                     //if($order_status->driver_id == null)
                                      //OrderStatusEmail::noRiderAccept($order_id);
                                  
                                  }
                           
                            $i++;
                          
                           }
                      }
                   }
                
                }
              }
            }
          }


//$this->UpdateOrderStatus($order_number);


$check_rider_state = RiderHistory::where('order_number',$order_id)
                                ->where('status','pending')
                                ->orWhere('status','accept')
                                ->orWhere('status','delivered')
                                ->first();

if(!$check_rider_state) // meaning that no rider accept this order
{

Order::find($order_id)->update(['job_execute'=>1]);

}

}



public function findRider($lat,$long,$distance,$limit)
 {

      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://riderapi.spoongate.com/api/riders/locations";    
        try
        {
        $response = $client->request('GET', $endpoint, ['query' => [
                    'lat'=> $lat,
                    'long' => $long,
                    'distance' => $distance,
                     'limit' =>  $limit,
        ]]);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $content = json_decode($response->getBody(), true);
        return $content;
         }
          catch (Exception $e)
             {
             echo "Error: " . $e->getMessage();
             }


  }    


public function SendNotificationToRider($order_id,$uuid)
 {
     
      $offers = OrderOffer::where('order_number',$order_id)->first();
      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://riderapi.spoongate.com/api/notifications";    

        try
        {
        $response = $client->request('POST', $endpoint, ['query' => [
                    'user_uuid'=> $uuid,
                    'title' => 'Order # '.$order_id,
                    'body' => 'You have new order please check it before next 30s',
                    'data' => $offers->data
        ]]);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $content = json_decode($response->getBody(), true);
      }

          catch (Exception $e)
             {
             echo "Error: " . $e->getMessage();
             }


  } 

}