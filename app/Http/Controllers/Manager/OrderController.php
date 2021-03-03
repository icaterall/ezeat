<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\User;
use Facades\App\Models\OrderStatus;
use Facades\App\Models\RiderHistory;
use Facades\App\Models\Coupon;
use Spatie\Permission\Models\Role;
use Facades\App\Models\Order;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantUser;
use Facades\App\Helpers\DataTable;
use Facades\App\DataTables\OrderDataTable;
use Facades\App\Services\Emails\OrderStatusEmail;
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
          
           $data = Order::GetRestaurantOrders();

          if ($request->ajax()) { 
            return OrderDataTable::dataRestaurantTable($data);
            }

         return view('admin.merchants.orders.archive');
            
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
        //
    }
}
