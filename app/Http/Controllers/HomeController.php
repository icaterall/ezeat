<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Helpers\UserCart;
use Facades\App\Helpers\Helper;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       return view('homepage.index');
    }


//-----------------------------------------------------

    public function showLinkRequestForm()
    {

        return view('auth.passwords.email');
    }



  /**
     * Show Fixed pages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function Fixedpage()
    {
               $privacy = Helper::getKeyValue('privacy');
               $term_of_use =  Helper::getKeyValue('term_of_use');
               $customer_faq =  Helper::getKeyValue('customer_faq');
               $refund_policy =  Helper::getKeyValue('refund_policy');
               $contact = Helper::getKeyValue('contact');
               $about = Helper::getKeyValue('about');
                $cs_email = Helper::getKeyValue('cs_email');
                $hq_phone = Helper::getKeyValue('hq_phone');
                $mobile_sms = Helper::getKeyValue('mobile_sms');


        return view('fixedpages.fixedarchive',compact('privacy','term_of_use','customer_faq','refund_policy','contact','about','cs_email','hq_phone','mobile_sms'));
    }



}