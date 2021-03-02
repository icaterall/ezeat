<?php

namespace App\Helpers;

use Carbon\Carbon;
use Facades\App\Models\CatererUser;
use Facades\App\Models\Storeinfo;
use GuzzleHttp\Client;

use Session;
use Response;
use Str;
use DateTime;
use DateTimeImmutable;
use DatePeriod;
use DateInterval;
use DataTables;

class DataTable
{
    /**
     * @return array
     */
  
// Faild to send Notification to rider

    public function getUsersTable($data)
    {
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('active', function ($data) {
                if ($data->status == 1) {
                    return 'Yes';
                } 
                else return 'No';
                } 
               
            })
             ->addColumn('Actions', function ($data) {
               
               return '<a class="btn btn-success btn-sm"href="/customerservice/storeorder_cs_details/'.$data->id.'">
                <i class="fas fa-eye"></i> View  
              </a>  
             
              <button type="button" class="btn btn-danger btn-sm" id="getDeleteId" href="#DeleteModal" uk-toggle data-id="'.$data->name.'">
                <i class="fas fa-edit"></i> Delete
              </button>';
                
            })

            ->rawColumns(['Actions'])
            ->make(true);
    }

    

}