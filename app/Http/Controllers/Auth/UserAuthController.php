<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Facades\App\Models\SiteSetting;
use Facades\App\Models\Restaurant;
use Facades\App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;

class UserAuthController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * get all regions categorized by country.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    //Show Admin login Form
    public function LoginForm()
    {
        return view('auth.loginform');
    }

    //Show Caterer login Form
    public function CatererLoginForm()
    {
        return view('auth.catererloginform');
    }


    //Show Admin Registeration Form
    public function AdminRegistration()
    {
        return view('auth.manageauth.registerform');
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('loginform');
    }
}
