<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Models\CustomField;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;
use Barryvdh\DomPDF\Facade as PDF;

class CouponDataTable
{
   
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
       return  DataTables::of(Coupon::get())
                    ->addIndexColumn()          
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y / h:i a') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
            })
            

            ->editColumn('discount', function ($data) {
              if($data->discount_type == 'percent')
              return $data->discount.'%';
            else return $data->discount.' MYR';
               })


            ->editColumn('expires', function ($data) {
                
              if ($data->expires_at == null ) {
                 return 1;
              }

                else {
                    return(new Carbon($data->expires_at))->format('D  M-j-y / h:i a');
                     
                }

            })

            ->editColumn('restaurant', function ($data) {
                if ($data->restaurant_id == null) {
                    return 1;
                } else
                {
                    return $data->restaurants->name;
                }
            })
            
            ->editColumn('enabled', function ($data) {
                if ($data->enabled == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })

            ->editColumn('user', function ($data) {
                if ($data->user_id == null) {
                    return 1;
                } else
                {
                    return $data->users->name;
                }
            })

            ->addColumn('action', function($row){
                        return  view('admin.restaurants.coupons.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

  
    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'couponsdatatable_' . time();
    }
}