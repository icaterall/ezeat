<?php

namespace App\Http\Controllers;

use Facades\App\Helpers\SendSMS;
use Hash;
use Facades\App\Helpers\Helper;
use Facades\App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Facades\App\Models\Cart;
use Response;
use Session;
use Auth;


class ActivateCustomerController extends Controller
{


    public function ViewSMSverify()
    {

    $user_id = Auth::User()->id;
    $user=User::find($user_id);
    $carts = Cart::GetFinal($user_id);

if($user->status == 1)
{

if (Session::has('current_url'))
return redirect(Session::get('current_url')); 

if(count($carts['carts']) > 0 )
  return redirect()->route('checkout_review.index'); 
  return redirect()->route('home');       
}


else{
        return view('auth.sms_verification',compact('carts'));
    }


    }



   public function SMSverify(Request $request)
    {
    $user_id = Auth::User()->id;
    $user=User::find($user_id);
    if($request->activation_code == $user->activation_code)
    {
        $user->update(['status' => 1]);

           if (Session::has('current_url'))
                    
      return redirect(Session::get('current_url'));
      if(count($carts['carts']) > 0 )
      return redirect()->route('checkout_review.index'); 
      return redirect()->route('home');    

    } else
    return \Redirect::route('smsverify')->with('success', 'Verification code is not correct');

     }   


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
    }



    public function store(Request $request)
    {
       
    }

    public function edit($id)
    {}
  
    


// Resquest Code
    public function update(Request $request, $id)
    {
    
     $user_id = Auth::user()->id;   
     $data = User::find($user_id);

      $messages = ['mobile.required' => 'Mobile Number is required.'];

        $validator = \Validator::make($request->all(), [
                    'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10,'.$user_id,
                ], $messages);      

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

if($request->activation_code != null)
{
            if($request->activation_code == $data->activation_code)
            {
                $data->update(['status' => 1]);
                Session::flash('success', 'Your mobile number has been successfully verified'); 
                return route('customer_address.index');
            }

        // Code is not correct
         else         
         {
          return Response::json([
                             'message'   =>  'Verification code is not correct'
                         ]);
          }

  }

else


{

         $code = rand(1000, 9999);
        $data->update([
            'activation_code' => $code,
            'mobile' => $request->mobile
        ]);    
        SendSMS::sendUserSms($request->mobile,$code); // send and return its response
        Session::flash('success', 'The activation code has been sent successfully.');
       
}


        return response()->json(['success' => 'Updated successfully']);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
    }

    public function show($id)
    {
    }
}
