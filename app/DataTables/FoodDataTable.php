<?php

namespace App\DataTables;

use Facades\App\Models\Food;
use DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use validate;
use Str;
use Barryvdh\DomPDF\Facade as PDF;

class FoodDataTable
{
  

  public function dataTable()
    {
         
        $restaurant_ids = [];

         foreach(Auth::user()->restaurants as $key => $value)
         {
           $restaurant_ids[] = $value->id;
         }

       return  DataTables::of(Food::whereIn('restaurant_id',$restaurant_ids)->get())
                    ->addIndexColumn()          
          

          ->editColumn('updated_at', function ($data) {
                return [
                    'display' => ($data->updated_at) ? with(new Carbon($data->updated_at))->format('D n-j-y / h:i a') : '',
                    'timestamp' => ($data->updated_at) ? with(new Carbon($data->updated_at))->timestamp : '',];
            })
        ->editColumn('category', function ($data) {

                    return $data->category->name;
            })

        ->editColumn('restaurant', function ($data) {

                    return $data->restaurant->name;
            })
        
    ->editColumn('featured', function ($data) {
                if ($data->featured == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })
    
    ->editColumn('restaurant_price', function ($data) {
                return 'MYR '.$data->restaurant_price;
            })

    ->editColumn('deliverable', function ($data) {
                if ($data->deliverable == true) {
                    return 1;
                } else
                {
                    return 0;
                }
            })
->addColumn('name', function ($data) { 
       
if($data->image == null)
{
     $url=asset("uploads/noimage.png");
}
else $url=asset("uploads/productimages/$data->image");

       return '<div class="d-flex align-items-center">
                                    <div class="symbol symbol-70 flex-shrink-0">
                                        <img src='.$url.' alt="'.$data->name.'" style="max-width: 120px">
                                    </div>


                                    <div  class="ml-3" style="
                                        width: 200px; >
                                        <span class="text-dark-75 font-weight-bold line-height-sm d-block pb-2" >'.$data->name.'</span>
                                       
                                    </div>
                                </div>';


        })

->addColumn('action', function($row){
        return  view('merchants.foods.action-buttons',compact('row'))->render();
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