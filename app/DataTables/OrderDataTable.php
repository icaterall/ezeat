<?php

namespace App\DataTables;

use App\Models\Order;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;
use Barryvdh\DomPDF\Facade as PDF;

class OrderDataTable
{
  public function dataTable($data)
    {

       return  DataTables::of($data)
                    ->addIndexColumn()          
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
            })

            ->editColumn('client', function ($data) {

                    return $data->user->name;
            })
             ->editColumn('total', function ($data) {
              return $data->total.' MYR';
               })

             ->editColumn('restaurant_total', function ($data) {
              return $data->restaurant_total.' MYR';
               })

            ->editColumn('restaurant', function ($data) {

                    return $data->foods->first()->restaurant->name;
                    
            })

            ->editColumn('active', function ($data) {
                if ($data->active == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })
            ->editColumn('is_app', function ($data) {
                if ($data->is_app == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })

            ->addColumn('action', function($row){
                        return  view('admin.orders.all_orders.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function dataRestaurantTable($data)
    {
       return  DataTables::of($data)
                    ->addIndexColumn()          
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
            })

            ->editColumn('client', function ($data) {

                    return $data->user->name;
            })
             ->editColumn('total', function ($data) {
              return $data->restaurant_total.' MYR';
               })

            ->editColumn('active', function ($data) {
                if($data->active == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })

            ->addColumn('action', function($row){
                        return  view('merchants.orders.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }



    public function dataPaymentOrderTable($data)
    {
       return  DataTables::of($data)
                    ->addIndexColumn()          
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
            })

            ->editColumn('client', function ($data) {

                    return $data->user->name;
            })
             ->editColumn('total', function ($data) {
              return $data->restaurant_total.' MYR';
               })

            ->editColumn('active', function ($data) {
                if ($data->active == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })->make(true);
    }


}