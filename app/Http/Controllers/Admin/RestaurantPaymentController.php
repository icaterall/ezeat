<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\DataTables\RestaurantPaymentDataTable;
use App\Models\RestaurantsPayout;
use Facades\App\Models\Restaurant;
use Facades\App\Models\Order;
use Carbon\Carbon;
use Auth;
use Redirect;
use DB;
use Facades\App\DataTables\OrderDataTable;
use Session;

class RestaurantPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    

     $total_orders = Order::GetRestaurantPayment(); 

     $total_orders = $total_orders->groupBy('restaurant_id');

        if ($request->ajax()) {
            return RestaurantPaymentDataTable::dataTable($total_orders);
            }
         return view('admin.finance.restaurants.archive');
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentHistoryArchive(Request $request)
    {

        if ($request->ajax()) {
            return RestaurantPaymentDataTable::dataTableHistory();
            }
         return view('admin.finance.restauranthistory.archive');
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::orderBy('id','DESC')->pluck('name','id')->all();
        return view('admin.finance.restaurants.create',compact('restaurants'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PayToRestaurant(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        $restaurant = Restaurant::find($restaurant_id);
        $total_orders = Order::GetRestaurantPayment(); 
       $total_orders = $total_orders->where('restaurant_id',$request->restaurant_id); 
        return view('admin.finance.restaurants.create',compact('restaurant','total_orders'));
    }

    
 public function getAjaxPayment(Request $request)
    {
      
         $total_orders = Order::GetRestaurantPayment();
      

         $total_orders = $total_orders->groupBy($request->restaurant_id)->first();
         $checkid = $request->checkid;

        if($checkid == 'all')
          $checkid = $total_orders->where('restaurant_id',$request->restaurant_id)->pluck('id')->toArray();  
        if($checkid == 'none')
          $checkid = [];

         $total_amount = $total_orders->whereIn('id',$checkid)->sum('restaurant_total');

          return response()->json([
            'success' => 'Created User successfully',
            'amount' => number_format($total_amount, 2, '.', ',').' '.'MYR',
            'checkid' => $checkid

            
          ]);

    }



     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PayOrders(Request $request)
    {


       
        if ($request->ajax()) {
    
     $total_orders = Order::GetRestaurantPayment(); 
     $total_orders = $total_orders->where('restaurant_id',$request->restaurant_id);    
      
            return OrderDataTable::dataPaymentOrderTable($total_orders);
            }
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
             $input = $request->except(['checkid','checkable']);
            $messages = [
                'restaurant_id.required' => 'Restaurant field is required.',
                'method.required' => 'Method field is required.',
                'paid_date.required' => 'Paid date field is required.',
                'checkid.required' => 'You must select orders from the table.'
             ];
            
            $validator = \Validator::make($request->all(), [
                'checkid' => 'required',
                'paid_date' => 'required',
                'method' => 'required',
                'restaurant_id' => 'required',
                
            ], $messages);

            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
            $paid_date = strtotime($request->paid_date);
            $paid_date = date('Y-m-d H:i:s', $paid_date);
            

            $input['paid_date'] = $paid_date;

             $checkid = explode(",", $request->checkid);
           
            $total_orders = Order::GetRestaurantPayment();
            
            $total_amount = $total_orders->whereIn('id',$checkid)->sum('restaurant_total');
          
       

            $input['amount'] = $total_amount;
            
            
            $data = RestaurantsPayout::create($input);
            $orders = Order::whereIn('id',$checkid)->update(['restaurant_payout_id'=>$data->id]);
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
           
           RestaurantsPayout::find($id)->delete();
           Order::where('restaurant_payout_id',$id)->update(['restaurant_payout_id'=>null]);

           return response()->json(['data' => trans('message.delete')]);

         } catch (ModelNotFoundException $e) {
         // Handle the error.
        }





          
          
    }
}
