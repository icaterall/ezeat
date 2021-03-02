<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Helper\Helper;
use Facades\App\Helpers\SendSMS;
use GuzzleHttp\Client;

class SmsController extends Controller
{
    
     
     protected $code, $smsVerifcation;

     function __construct()
		{
		}
		     

public function store(Request $request)
{
	$code = rand(1000, 9999); //generate random code
	$request['code'] = $code; //add code in $request body
	$request['user_id'] = 1; //add code in $request body
	$this->smsVerifcation->store($request); //call store method of model
	return $this->sendSms($request); // send and return its response
}


public function sendSms($request)
 {
 	  
 	  $apiKey = config('services.smsapi.ApiKey'); 
      $client = new \GuzzleHttp\Client();   
      $endpoint = "https://www.sms123.net/api/send.php";    
       
        try
        {
        $response = $client->request('GET', $endpoint, ['query' => [
            'recipients' => $request->contact_number, 
            'apiKey' => $apiKey,
            'messageContent'=>'SpoonGate.com verification code is '.$request->code,
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



		public function verifyContact(Request $request)
		 {
			 $smsVerifcation = 
			$this->smsVerifcation::where('contact_number','=',
			$request->contact_number)
			 ->latest() //show the latest if there are multiple
			 ->first();
			 if($request->code == $smsVerifcation->code)
			 {
			 $request["status"] = 'verified';
			 return $smsVerifcation->updateModel($request);
			 $msg["message"] = "verified";
			 return $msg;
			 }
			 else
			 {
			 $msg["message"] = "not verified";
			 return $msg;
			 }
		}


     public function sendsmsold(Request $request)
    {
       
      $smsresp=Helper::sendsms($request->number,$request->messageContent,$request->referenceID);
     
      if ($smsresp=='E00242')
      {
        return 'Invalid number';
      }
      else if ($smsresp=='E00001')
       {
        return 'success';
       }
       else
       {
        return 'something error';
       }
   
    }


}
