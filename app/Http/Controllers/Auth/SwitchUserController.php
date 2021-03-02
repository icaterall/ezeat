<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SwitchUserController extends Controller
{
    public function switchUserStart($id)
    {
       

        // Only customer service allowed
        $user = auth()->user();

        $new_user = User::find($id);

        if ($new_user) {
            Session::put('switch_user_original', Auth::id());
            Auth::login($new_user);
        }

        return redirect('manager_gate');
    }

    public function switchUserEnd()
    {
        $id = Session::pull('switch_user_original');

        if ($id) {
            Auth::loginUsingId($id, true);
        }

        return redirect('admin_gate');
    }
}
