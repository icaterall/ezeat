<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Models\Order;
use Facades\App\Models\User;
use Session;
use Carbon\Carbon;
use Route;
use Auth;
use DB;
use Response;
use Hash;
class CustomerController extends Controller
{
  

    /**
     * Display a placed order.
     *
     * @return \Illuminate\Http\Response
     */
    public function placedOrder($restaurant_id,$order_id)
    {
      $user_id = Auth::user()->id;   
      $order = Order::where('user_id',$user_id)->where('active',1)->find($order_id);
      if($order)
        return view('customers.orders.archive',compact('order'));
        return \Redirect::route('home');    
    }


    public function getOrderStatus(Request $request)
    {
      
      $order_id = $request->order_id;
      $order = Order::find($order_id);
      

      if($order->order_status_id == 4)
        
       { 
        
        if(Session::get('estimated_time') == 1)
            {
               
                Session::put(['estimated_time' => 0.5]);
                if($order->estimated_time == 1)
                $order->update(['estimated_time' => 1 ]);
                else $order->update(['estimated_time' => $order->estimated_time - 1 ]);
            } 

            else
            {
               Session::put(['estimated_time' => 1]); 
            }

        

       

       }

    

        $order_status = view('customers.orders.order_top_section',compact('order'))->render();
     

     return response()->json([
        'data' => trans('message.success'),
        'order_status' => $order_status,
        'order_id' => $order_id
 ]);    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function OrdersArchive()
    {
         $user_id = Auth::user()->id; 
         $orders = Order::where('user_id',$user_id)->where('active',1)->orderBy('id','desc')->get();
        return view('customers.customer_orders',compact('orders'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                 $user_id = Auth::user()->id; 
         $order = Order::where('user_id',$user_id)->get();
        return view('customers.customer_dashboard',compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
                'name.required' => 'Name field is required.',
                'email.unique' => 'Email already exists.',
                'email.required' => 'Email field is required.',
                'mobile.required' => 'Mobile field is required.',
                'mobile.unique' => 'Mobile already exists.',   

        ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'mobile' => '|unique:users,mobile,'.$id,
                'email' => 'required|email|unique:users,email,'.$id
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

      if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            
            $input = $request->except(['password']);  
        }
       $user = User::find($id);        
        $user->update($input);
        $name = $user->name;
        $email = $user->email;
        $mobile = $user->mobile;
        
        return Response::json([
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
        ]);
    
    return response()->json(['success' => 'Created User successfully']);
  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
