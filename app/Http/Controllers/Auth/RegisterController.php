<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Facades\App\Helpers\Helper;
use Facades\App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Facades\App\Helpers\SendSMS;
use Facades\App\Helpers\UserCart;
use Spatie\Permission\Models\Role;
use App\Repositories\RoleRepository;
use DB;
use Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handle the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showRegistrationForm()
    {
     
     $carts = UserCart::getCustomerItems();
        return view('auth.register',compact('carts'));
    }



    public function showLoginForm()
    {
            $carts = UserCart::getCustomerItems();
        return view('auth.login',compact('carts'));
    }



    public function redirectTo()
    {
      $carts = UserCart::getCustomerItems();
      return route('smsverify',compact('carts'));   
    }


    public function __construct()
    {
        $this->middleware('guest');
    }




    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array                                      $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array            $data
     * @return \App\Models\User
     */


    protected function create(array $data)
    {
        $code = rand(1000, 9999);
        SendSMS::sendUserSms($data['mobile'],$code); // send and return its response

        $user = new User;
        $user->name = $data['name'];
        $user->mobile = $data['mobile'];
        $user->email = $data['email'];
        $user->activation_code = $code;
        $user->password = Hash::make($data['password']);
        $user->api_token = Str::random(60);
        $user->save();
        $array = [];

        $defaultRoles = Role::where('default', '1')->first();
        $array = [$defaultRoles->name];
        $user->assignRole($array);

        return $user;
    }


}
