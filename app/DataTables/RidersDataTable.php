<?php

namespace App\DataTables;

use Facades\App\Models\RestaurantsPayout;
use Facades\App\Helpers\Helper;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;

class RidersDataTable
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

            ->editColumn('last_update', function($data){
               if($data->location->first() != null)
               return $data->location->first()->updated_at->diffForHumans();
               return '';
                    })
            ->editColumn('last_location', function($data){
               if($data->location->first() != null)
               {
                
        $response = Helper::getaddress($data->location->first()->lat,$data->location->first()->long);
    $result = json_decode($response);
    if(!empty($result->results))
        return $result->results[0]->formatted_address;
    return 'Unkown';

               }
               return '';
                    })
            ->editColumn('updated', function ($data) {
                 if($data->location->first() != null)
                {

                    return [
                    'display' => ($data->location->first()->updated_at) ? with(new Carbon($data->location->first()->updated_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->location->first()->updated_at) ? with(new Carbon($data->location->first()->updated_at))->timestamp : '',
                ];
            }
             else {

                    return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
             }


            
            })
            ->editColumn('active', function ($data) {
                if ($data->is_available == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })

          ->editColumn('approved', function ($data) {
                if ($data->is_approved == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })  
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
            })

           ->addColumn('action', function($row){

        return  view('admin.riders.action-buttons',compact('row'))->render();
                    })
       ->rawColumns(['action'])->make(true);
    }



}