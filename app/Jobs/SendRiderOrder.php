<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Facades\App\Models\Order;
use Facades\App\Models\OrderOffer;
use Facades\App\Helpers\GetRider;
class SendRiderOrder implements ShouldQueue
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
