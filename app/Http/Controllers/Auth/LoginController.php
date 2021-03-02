<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Facades\App\Helpers\Helper;
use Facades\App\Models\Restaurant;
use Facades\App\Models\User;
use Facades\App\Services\ResetEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Facades\App\Helpers\UserCart;
use Redirect;
use Session;
use Route;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */



 public function redirectTo()
    {


           if(Auth::User()->status == 0)
           {

      $carts = UserCart::getCustomerItems();
      return route('smsverify',compact('carts'));

           }


/*        if (!empty(Cart::content()->first())) {
            $storeinfo = Storeinfo::findOrFail((Cart::content()->first())->options->storeinfo_id);
            $cartContents = Cart::content();

            return route('GetContactInfo');
        }
*/


    }

    


    public function login(Request $request)
    {

        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    protected function authenticated(Request $request, $user)
    {
   
        if(Auth::User()->status==0)
           {

      $carts = UserCart::getCustomerItems();
      return route('smsverify',compact('carts'));

           }

           else if (Session::has('current_url')){
                   
                   return redirect(Session::get('current_url'));

                  }

        
        return redirect()->intended($this->redirectTo);

    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function username()
    {
        return 'email';
    }

    public function logoutUser()
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }
}
