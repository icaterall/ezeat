<?php

namespace App\DataTables;

use Facades\App\Models\Restaurant;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;

class RestaurantDataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
                
  
       return  DataTables::of(Restaurant::get())
                    ->addIndexColumn()          
          
          ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',];
            })

    ->editColumn('active', function ($data) {
                if ($data->active == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })
    
    ->editColumn('accept_cash', function ($data) {
                if ($data->accept_cash == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })

->addColumn('logo', function ($data) { 
       
if($data->logo == null)
{
     $url=asset("uploads/noimage.png");
}
else $url=asset("uploads/storelogo/$data->logo");

       return '<div class="d-flex align-items-center">
                                    <div class="symbol symbol-70 flex-shrink-0">
                                        <img src='.$url.' alt="'.$data->name.'" style="max-width: 80px">
                                    </div>';


        })

->addColumn('action', function($row){

        return  view('admin.restaurants.all_restaurants.action-buttons',compact('row'))->render();
                    })
       ->rawColumns(['logo', 'action'])->make(true);


    }


}