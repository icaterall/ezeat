<?php
namespace App\Services\Payment;


use Redirect;
use Auth;
use Facades\App\Models\Order;
use Facades\App\Models\OrderUser;
use Facades\App\Models\User;
use Facades\App\Services\Payment\SaveOrderToCart;
use Session;
use Facades\App\Services\Emails\OrderStatusEmail;
class KipleOnlineBanking
{


    public function __construct()
    {

    }


///////--------------------- WEB KiplePay

       public function OnlineKiplePayBanking($amount,$code,$user_id,$returnURL,$isApp)
{
       $order = OrderUser::where('user_id',$user_id)->first();

       if($order != null)
         {
            try {
             Order::destroy($order->order_id);
             }    catch (ModelNotFoundException $e) {
           }
         }

      if($isApp == true)
       
       $order_id = SaveOrderToCart::SaveAppToOrders($user_id);
     
     else $order_id = SaveOrderToCart::SaveToOrders(0,$user_id);

     
       $user = User::find($user_id);
       OrderUser::create(['user_id' => $user_id,'order_id'=>$order_id]);
      $user_name = $user->name;
      $user_phone = $user->mobile;
      $user_email = $user->email;
      $prm_date         =  gmdate("Y-m-d H:i:s",time()+(8*60*60));
      $prm_amount       =  round($amount,2);
      $prm_mrhref       =  $order_id; //from your orders;
      $prm_mrhid        =  config('services.kiple.username'); // test MID
      $prm_mrhsKey      =  config('services.kiple.ApiKey');// test secret key
      $payment_code     = $code;
      $prm_returnURL    =  $returnURL;

      $prm_payment_mrh_hash = sha1($prm_mrhsKey . $prm_mrhid . $prm_mrhref . str_replace('.', '', $prm_amount));
//set POST variables
$url = config('services.kiple.url');

$form_pymnt = "<html><head></head>"."\n";
$form_pymnt = "<body onload=\"document.createElement('form').submit.call(document.getElementById('kiplepay_form'))\" >"."\n";
$form_pymnt .= "<form action='".$url."' method='post' id='kiplepay_form'  >"."\n";
$form_pymnt .= "<input type='hidden' name='ord_date' value='".$prm_date."'>"."\n";
$form_pymnt .= "<input type='hidden' name='ord_shipcountry' value='MY'>"."\n";
$form_pymnt .= "<input type='hidden' name='ord_gstamt' value='0.00'>"."\n";
$form_pymnt .= "<input type='hidden' name='ord_delcharges' value='0.00'>"."\n";
$form_pymnt .= "<input type='hidden' name='ord_svccharges' value='0.00'>"."\n";
$form_pymnt .= "<input type='hidden' name='ord_shipname' value='".$user_name."'>"."\n"; //use the name from your app or web-based
$form_pymnt .= "<input type='hidden' name='ord_telephone' value='".$user_phone."'>"."\n"; //use the name from your app or web-based
$form_pymnt .= "<input type='hidden' name='ord_email' value='".$user_email."'>"."\n"; //use the name from your app or web-based
$form_pymnt .= "<input type='hidden' name='ord_mercID' value='".$prm_mrhid."'>"."\n"; 
$form_pymnt .= "<input type='hidden' name='ord_mercref' value='".$prm_mrhref."'>"."\n"; //use the name from your app or web-based
$form_pymnt .= "<input type='hidden' name='ord_totalamt' value='".$prm_amount."'>"."\n"; //use the name from your app or web-based
$form_pymnt .= "<input type='hidden' name='merchant_hashvalue' value='".$prm_payment_mrh_hash."'>"."\n"; 
$form_pymnt .= "<input type='hidden' name='payment_code' value='".$payment_code."'>"."\n"; 
$form_pymnt .= "<input type='hidden' name='ord_returnURL' value='".$prm_returnURL."'>"."\n"; //use the name from your app or web-based
$form_pymnt .= "<input type='hidden' name='version' value='2.0'>"."\n"; 
$form_pymnt .= "<input type='hidden' name='submit' id='submit' value='Pay with kiplePay'>"."\n"; 
$form_pymnt .= "</form>"."\n"; 
$form_pymnt .= "<br />"."\n"; 
$form_pymnt .= "</body>"."\n"; 
$form_pymnt .= "</html>"."\n"; 
echo $form_pymnt;

    }



}




