<?php

namespace App\Helpers;

use Carbon\Carbon;
use Facades\App\Models\CatererUser;
use Facades\App\Models\Storeinfo;
use GuzzleHttp\Client;

use Session;
use Response;
use Str;
use DateTime;
use DateTimeImmutable;
use DatePeriod;
use DateInterval;

class SendSMS
{
    /**
     * @return array
     */
  
// Faild to send Notification to rider

    public function NotifyNoRider($contact_number,$order_number)
 {
      
      $apiKey = config('services.smsapi.ApiKey'); 
      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://www.sms123.net/api/send.php";    
       
        try
        {
        $response = $client->request('GET', $endpoint, ['query' => [
            'recipients' => $contact_number, 
            'apiKey' => $apiKey,
            'messageContent'=>'spoongate.com - We were unable to reach any riders for order # '.$order_number,
        ]]);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $content = json_decode($response->getBody(), true);
        return $content['msgCode'];

         }
          catch (Exception $e)
             {
             echo "Error: " . $e->getMessage();
             }
    }    



public function sendOrderSms($contact_number,$link)
 {
      
      $apiKey = config('services.smsapi.ApiKey'); 
      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://www.sms123.net/api/send.php";    
       
        try
        {
        $response = $client->request('GET', $endpoint, ['query' => [
            'recipients' => $contact_number, 
            'apiKey' => $apiKey,
            'messageContent'=>'You have just received a new order:'.$link,
        ]]);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $content = json_decode($response->getBody(), true);
        return $content['msgCode'];

         }
          catch (Exception $e)
             {
             echo "Error: " . $e->getMessage();
             }
    }    


   public function sendUserSms($contact_number,$code)
 {
      
      $apiKey = config('services.smsapi.ApiKey'); 
      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://www.sms123.net/api/send.php";    
       
        try
        {
        $response = $client->request('GET', $endpoint, ['query' => [
            'recipients' => $contact_number, 
            'apiKey' => $apiKey,
            'messageContent'=>'SpoonGate.com verification code is '.$code,
        


        ]]);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $content = json_decode($response->getBody(), true);
        return $content['msgCode'];

         }
          catch (Exception $e)
             {
             echo "Error: " . $e->getMessage();
             }
    }  
// ---------- Send To customer if pickup
public function sendPickupSms($contact_number,$store_name)
 {
      
      $apiKey = config('services.smsapi.ApiKey'); 
      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://www.sms123.net/api/send.php";
        try
        {
        $response = $client->request('GET', $endpoint, ['query' => [
            'recipients' => $contact_number, 
            'apiKey' => $apiKey,
            'messageContent'=>'spoongate.com - Dear customer, your order from '.$store_name. ' is ready please come and collect it',
        ]]);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $content = json_decode($response->getBody(), true);
        return $content['msgCode'];

         }
          catch (Exception $e)
             {
             echo "Error: " . $e->getMessage();
             }
    }  

}