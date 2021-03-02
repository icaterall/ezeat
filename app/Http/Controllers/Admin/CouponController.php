<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\User;
use Facades\App\Models\Coupon;
use Spatie\Permission\Models\Role;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantUser;
use Facades\App\Helpers\DataTable;
use Facades\App\DataTables\CouponDataTable;
use Facades\App\Models\Cart;
use Facades\App\Models\Order;
use Session;
use Response;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
           
          if ($request->ajax()) {
            return CouponDataTable::dataTable();
            }

         return view('admin.restaurants.coupons.archive');
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $data=Coupon::all();
        $users=User::orderBy('name','asc')->pluck('name','id')->all();
        $status = Helper::status();
        $singleuse = Helper::couponUse();
        $discountType = Helper::couponType();
        $restaurants = Restaurant::orderBy('name','asc')->pluck('name','id')->all();
        return view('admin.restaurants.coupons.create',compact('data','users','status','singleuse','restaurants','discountType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $input = $request->all();
            $messages = [
                'code.required' => 'Code field is required.',
                'discount.required' => 'Discount field is required.',
                'description.required' => 'Description field is required.',
                'single_use.required' => 'Time of use field is required.',
                'single_use.required' => 'Active field is required.',
                'code.unique' => 'Code already exists.'
        ];
            
            $validator = \Validator::make($request->all(), [
               'code' => 'required|unique:coupons',
                'discount' => 'required|numeric|min:1|max:100',
                'minimum_order' => 'numeric|min:0|max:100',
                'description' => 'required',
                'single_use' => 'required',
                'enabled' => 'required',
                
            ], $messages);

            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


      if ($request->expires_at != null) {

            $expires_at = strtotime($request->expires_at);
            $expires_at = date('Y-m-d H:i:s', $expires_at);
            $input['expires_at'] = $expires_at;

        }


        $data = Coupon::create($input);

        return response()->json(['success' => 'Created item successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    

        $data=Coupon::findOrFail($id);
        $status = Helper::status();
        $singleuse = Helper::couponUse();
        $restaurants = Restaurant::orderBy('name','asc')->pluck('name','id')->all();
        $users=User::orderBy('name','asc')->pluck('name','id')->all();
        $discountType = Helper::couponType();

        return view('admin.restaurants.coupons.edit',compact('discountType','data','restaurants','status','singleuse','users'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
            $input = $request->all();
            $messages = [
                'code.required' => 'Code field is required.',
                'discount.required' => 'Discount field is required.',
                'description.required' => 'Description field is required.',
                'single_use.required' => 'Time of use field is required.',
                'single_use.required' => 'Single use field is required.',
                'code.unique' => 'Code already exists.'
        ];
            
            $validator = \Validator::make($request->all(), [
               'code' => 'required|unique:coupons,code,'.$id,
                'discount' => 'required|numeric|min:1|max:100',
                'minimum_order' => 'numeric|min:0|max:100',
                'description' => 'required',
                'single_use' => 'required',
                'enabled' => 'required',
                
            ], $messages);

            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


      if ($request->expires_at != null) {

            $expires_at = strtotime($request->expires_at);
            $expires_at = date('Y-m-d H:i:s', $expires_at);
            $input['expires_at'] = $expires_at;

        }
        if($request->user_id == null)
        {
           $input['user_id'] = null;  
        }

        if($request->restaurant_id == null)
        {
           $input['restaurant_id'] = null;  
        }

        $data = Coupon::find($id);
        $data->update($input);

        return response()->json(['success' => 'Update item successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          Coupon::find($id)->delete();  
          return response()->json(['data' => trans('message.delete')]);
    }

 public function applypromo(Request $request)
    {
        $user_id = Auth::user()->id;
        $carts = Cart::GetFinal($user_id);
        $subtotal = $carts['subtotal'];
        $promo = Coupon::where('code', $request->promocode)->first();
        $restaurant = $carts['carts']->first()->food->restaurant;
                //---------------------

        if (!empty($promo)) {
            if ($promo->expiration_date != '0000-00-00 00:00:00') {
                $today_date = Carbon::now();
                $expire_date = $promo->expiration_date;
                $data_difference = ($today_date->diffInDays($promo->expiration_date, false)) + 1;  //false param
            }

            if (($promo->restaurant_id != null) and ($promo->restaurant_id != $restaurant->id)) {
                $message = 'This promotion cannot be used for this restaurant';
                $promoisaccepted = 0;
            } elseif (($promo->minimum_order != null) and ($promo->minimum_order > $subtotal)) {
                $message = 'The minimum order for this promotion is MYR'.$promo->minimum_order;
                $promoisaccepted = 0;
            } elseif (($promo->user_id != null) and ($promo->user_id != $user_id)) {
                $message = 'You cannot use this promotion';
                $promoisaccepted = 0;
            } elseif (($promo->expiration_date != '0000-00-00 00:00:00') and ($data_difference <= 0)) {
                $message = 'Promotion has expired';
                $promoisaccepted = 0;
            } elseif (($promo->single_use == 1) and ((Order::where('promo_code', $promo->code)->where('user_id', $user_id)->first()) != null)) {
                $message = 'You have used this promotion before';
                $promoisaccepted = 0;
            } elseif ($promo->enabled == 0) {
                $message = 'This promo is not avilable';
                $promoisaccepted = 0;
            } 

            else {


               session()->forget('discount');
               session()->forget('discount_type');
               session()->forget('promostatus');
                $message = 'accepted';
                $promoisaccepted = 1;
                Session::put(['promostatus' => 'accepted']);
                Session::put(['promocode' => $promo->code]);
                Session::put(['discount' => $promo->discount]);
                Session::put(['discount_type' => $promo->discount_type]);
                if($promo->restaurant_id != null)
                Session::put(['restaurant_promo' => $promo->restaurant_id]);    
                $carts = Cart::GetFinal($user_id);
                 

                 }

        } else { // If the promo code wasn't found
            $message = 'We do not recognize this code. Check that you have entered it correctly and try again.';
            $promoisaccepted = 0;
        }
      
        $promoform = view('customers.checkout.promotion_entry')->render();
        $checkout_cart = view('cart.desktop_cart_summary', compact('carts'))->render();
         $checkout_cart_mobile = view('cart.mobile_cart_summary', compact('carts'))->render();
        return Response::json([
            'message' => $message,
            'promoisaccepted' => $promoisaccepted,
            'checkout_cart' =>$checkout_cart,
            'checkout_cart_mobile' =>$checkout_cart_mobile,
            'promoform' => $promoform,
        ]);

    }


    //Remove Promo--------------

    public function removepromo(Request $request)
    {
        session()->forget('promostatus');
        session()->forget('discount');
        session()->forget('discount_type');
        $carts = Cart::GetFinal(Auth::user()->id);

        $promoform = view('customers.checkout.promotion_entry')->render();
        
        $checkout_cart = view('cart.desktop_cart_summary', compact('carts'))->render();
        $checkout_cart_mobile = view('cart.mobile_cart_summary', compact('carts'))->render();

        return Response::json([
            'promoform' => $promoform,
             'checkout_cart' =>$checkout_cart,
            'checkout_cart_mobile' =>$checkout_cart_mobile
        ]);
    }
   

}
