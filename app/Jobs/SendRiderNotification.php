<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Facades\App\Models\Order;
use Facades\App\Services\SendEmail;
class SendRiderNotification implements ShouldQueue
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
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;
             //-------- Send to Customer
        $order_customer_url =  '/customer/order-placed/'.$restaurant->id.'/'.$order->id;
        $customer_title = ('Good notification');
        SendEmail::SendOrderEmail($order_id, 'notification is ready' , 'ashqahman@gmail.com' , Null,$order,$order->total,$order_customer_url,$customer_title); 
    
    }
}