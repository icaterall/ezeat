<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Facades\App\Models\Order;
use Facades\App\Helpers\GetRider;
use Facades\App\Models\OrderOffer;
use Facades\App\Models\Rider;
use Facades\App\Models\RiderHistory;

class SendRiderNewOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($order_id,$uuid)
    {
    
    
    $offers = OrderOffer::where('order_number',$order_id)->first();
    $rider = Rider::where('uuid',$uuid)->first();

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
        }


   if($offers AND $offers->status == 'pending')
                 
     { 

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
        

       sleep(30);

       //if the last rider igored the order, set his status igonre
    $rider_history = RiderHistory::where('order_number',$order_id)
                                ->where('rider_id',$rider->id)
                                ->where('status','pending')
                                ->first();

    if($rider_history)
    $rider_history->update(['status' => 'ignore']);



        }
   }
}
