<?php

namespace App\services\Emails;
use Illuminate\Http\Request;
use Facades\App\Helpers\Helper;
use Facades\App\Models\Restaurant;
use Illuminate\Support\Facades\Config;
use Facades\App\Services\SendEmail;
use Auth;
use Session;
use Response;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RestaurantStatusEmail
{

    private $order_email;
    private $cs_email;
    private $admin_email;
    private $url;

    public function __construct()
    {
        $this->admin_email = Helper::getKeyValue('admin_email');
        $this->cs_email = Helper::getKeyValue('cs_email');   
        $this->url = Config::get('app.url'); 
    }

//----------Send first ordering attempt Email

    public function NewRestaurantEmail($restaurant)
    {     
     
        $user = Auth::user();
           //-------- Send to CService
        SendEmail::SendRestaurantEmail($restaurant,$user,$this->cs_email,$this->admin_email); 
    }



}


