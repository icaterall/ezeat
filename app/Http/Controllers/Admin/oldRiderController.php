<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Facades\App\Models\OrderOffer;
use Facades\App\Models\Rider;
use Facades\App\Models\RiderWallet;
use Facades\App\Models\RiderHistory;
use Facades\App\Models\RiderLocation;
use Session;
use DataTables;
use Carbon\Carbon;
use Facades\App\Helpers\Helper;


class oldRiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    
    {
    
        $data = Rider::get();

        if ($request->ajax()) {
            return RidersDataTable::dataTable($data);
            }
         return view('admin.riders.archive');
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
        //
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
        
        $wallet = RiderWallet::where('rider_id',$id)->first();
        if($wallet)
        $wallet->delete();
    
        Rider::findOrFail($id)->delete();
        return response()->json(array('data' => trans('message.delete')));
    }
}
