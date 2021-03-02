<?php

namespace App\DataTables;

use Facades\App\Models\Extra;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;
use Barryvdh\DomPDF\Facade as PDF;

class ExtraDataTable
{
  

  public function dataTable($food_id)
    {
         
       return  DataTables::of(Extra::where('food_id',$food_id)->get())
                    ->addIndexColumn()          


        ->editColumn('group', function ($data) {

                    return $data->extraGroup->name;
            })

    ->editColumn('price', function ($data) {
                return 'MYR '.$data->restaurant_price;
            })


->addColumn('action', function($row){
        return  view('merchants.foods.extras.action-buttons',compact('row'))->render();
                    })
       ->rawColumns(['name', 'action'])->make(true);


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