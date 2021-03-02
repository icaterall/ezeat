<?php

namespace App\DataTables;

use Facades\App\Models\RestaurantsPayout;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;

class RestaurantPaymentDataTable
{


    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($data)
    {
       return  DataTables::of($data)
                    ->addIndexColumn()          

          ->editColumn('total', function ($data) {
  
            return number_format($data->sum('restaurant_total'), 2, '.', ',').' '.'MYR';

            })
            
             ->editColumn('orders', function ($data) {
  
            return $data->count();

            })
    ->editColumn('restaurant', function ($data) {
           return $data->first()->restaurant->name;
            })



->addColumn('action', function($row){

        return  view('admin.finance.restaurants.action-buttons',compact('row'))->render();
                    })
       ->rawColumns(['action'])->make(true);
    }


//-----------Payment History
    public function dataTableHistory()
    {
       return  DataTables::of(RestaurantsPayout::get())
                    ->addIndexColumn()          

         ->editColumn('paid_date',function($data){
      return [
                    'display' => ($data->paid_date) ? with(new Carbon($data->paid_date))->format('D n-j-y / h:i a') : '',
                    'timestamp' => ($data->paid_date) ? with(new Carbon($data->paid_date))->timestamp : '',];
})   
  
   ->editColumn('updated_at',function($data){
      return [
                    'display' => ($data->updated_at) ? with(new Carbon($data->updated_at))->format('D n-j-y / h:i a') : '',
                    'timestamp' => ($data->updated_at) ? with(new Carbon($data->updated_at))->timestamp : '',];
})   


         ->editColumn('amount', function ($data) {
         $total = number_format($data->amount, 2, '.', ',');
         return $total.' '.'MYR';

            })   
        
        ->editColumn('orders', function ($data) {
            return $data->count();
            })
    ->editColumn('restaurant', function ($data) {
           return $data->restaurant->name;
            })



->addColumn('action', function($row){

        return  view('admin.finance.restauranthistory.action-buttons',compact('row'))->render();
                    })
       ->rawColumns(['action'])->make(true);
    }

}