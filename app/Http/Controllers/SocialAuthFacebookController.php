<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocialFacebookAccountService;

use Socialite;

class SocialAuthFacebookController extends Controller
{
  /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect()
    {
       
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service)
    {

    $socialUser = Socialite::driver('facebook')->fields(['name', 'first_name', 'last_name', 'email'])->user();


if($socialUser->email == null)
 {  
    return \Redirect::route('user.register')->withSuccess('Sorry, your account with facebook cannot be registered because an email address is missing.');  
}

else {
        $user = $service->createOrGetUser($socialUser);
        auth()->login($user);
        return redirect()->to('/');
      }
      
    }
}