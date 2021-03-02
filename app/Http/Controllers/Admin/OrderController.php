<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\User;
use Facades\App\Models\OrderStatus;
use Facades\App\Models\Coupon;
use Facades\App\Models\RiderHistory;
use Spatie\Permission\Models\Role;
use Facades\App\Models\Order;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantUser;
use Facades\App\Helpers\DataTable;
use Facades\App\DataTables\OrderDataTable;
use Facades\App\Services\Emails\OrderStatusEmail;
use Facades\App\Helpers\GetRider;
use PDF;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;
use Geocoder;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
           
    //dd(Order::first()->foods->first()->restaurant->name);
          if ($request->ajax()) {
            $data = Order::GetAllOrders();

            return OrderDataTable::dataTable($data);
            }

         return view('admin.orders.all_orders.archive');
            
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

    
    }
       
     public function viewOrder(Request $request,$id,$secret)
    {


        $order = Order::where('id',$id)
        ->where('secret',$secret)
        ->first();
         
        $view = 'merchants.orders.order_details.order_details';

        if(Auth::Check())
       if(Auth::user()->hasrole('admin'))
        $view = 'admin.orders.all_orders.order_details.order_details';
        

if($order)
{

        $restaurant = $order->foods->first()->restaurant;
        $status = OrderStatus::all();
        $order_driver_status = RiderHistory::where('order_number',$id)->first();   
        if($order_driver_status != null)
        $order_driver_status = $order_driver_status->status_note;
        $promo_code = $order->promo_code;
       $discount = 0;
       if($promo_code != null)
       {
        $coupon = Coupon::where('code',$promo_code)->first();
        if($coupon->restaurant_id != null)
        {
            if($coupon->restaurant_id == $restaurant->id);
            $discount = 1;
        }
      }
    $rider_serach = 0;
    Order::getRider($order);
    
    if(($order->isdelivery == 1) AND ($order->has_riders == 0) AND ($order->order_status_id != 1) AND ($order->driver_id == null) AND $order->job_execute == 0 )
     $rider_serach = 1; 

  
      

    return view($view,compact('order_driver_status','order','status','discount','rider_serach'));
}
return view('homepage.index');


    }
  

//-------------- Update on order

     public function updateOrder(Request $request,$order_id,$secret,$status)
    {
      
      $order_details = Order::find($order_id);
      if ($request->ajax()) {
       if($order_details)
       {
    switch ($status) {
        case 'confirm':
        $order_details
        ->update([ 
              'order_status_id' => 2,
              'order_status_note' => 'The restaurant is preparing food now',
              ]);
       //OrderStatusEmail::merchantAccept($order_id);
       

        break;  

        case 'cooking':
        $order_details
        ->update([ 
              'order_type' => 'asap',
              'estimated_time' => 25,
              'order_status_note' => 'The restaurant is preparing food now',
              ]);
        break;

        case 'ready':
         $order_details
         ->update([ 
              'order_status_id' => 3,
              'estimated_time' => 15,
              'order_status_note' => 'The food is ready for collect',
              ]);
           if($order_details->isdelivery == 0)
            OrderStatusEmail::foodIsReady($order_id);
            break;
         
       case 'onway':
        $order_details
         ->update([ 
              'order_status_id' => 4,
              'estimated_time' => 10,
              'order_status_note' => 'Order is on the way',
              ]);  

            break;   
         
       case 'delivered':
            
        $order_details
         ->update([ 
              'order_status_id' => 5,
              'estimated_time' => 0,
              'order_status_note' => 'Order has been delivered',
              ]);  
            break;  

     
      case 'decline':
         
         $order_details
         ->update([
          'active' => 0,
          'order_status_note' => 'The restaurant canceled this order']);
         OrderStatusEmail::declinedOrder($order_id);
        break;
       case 'cs_decline':

        $order_details
         ->update([
          'active' => 0,
          'order_status_note' => 'Spoongate canceled this order']);
         OrderStatusEmail::declinedOrder($order_id);
        break;

   }

  
       return response()->json(array('data' => trans('message.success')));

       }

     }
    }  


    // download
    public function downloadPDF($order_id)
    {
        $data = Helper::getPdfOrder($order_id);
        $pdf = PDF::loadView('admin.orders.all_orders.order_details.pdf_view', $data);
        return $pdf->download(time().'Order_'.$order_id.'.pdf');
    }

    // show
    public function printmePDF($order_id)
    {
    
        $data = Helper::getPdfOrder($order_id);
        return view('admin.orders.all_orders.order_details.pdf_view', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          
    try {
           
           Order::find($id)->delete();
           RiderHistory::where('order_number',$id)->delete();

           return response()->json(['data' => trans('message.delete')]);

         } catch (ModelNotFoundException $e) {
         // Handle the error.
        }


          return response()->json(['data' => trans('message.delete')]);
    }
}
