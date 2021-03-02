<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Facades\App\Models\OrderOffer;
use Facades\App\Models\Rider;
use Facades\App\Models\RiderWallet;
use Facades\App\Models\RiderHistory;
use Facades\App\Models\RiderLocation;
use Facades\App\Models\RiderProfile;
use Facades\App\Models\StageAmount;


use Session;
use Facades\App\DataTables\RidersDataTable;
use Carbon\Carbon;
use Facades\App\Helpers\Helper;


class RiderController extends Controller
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
     
        $data=Rider::findOrFail($id);
        $status = Helper::status();
        $profile = RiderProfile::where('rider_id',$data->id)->first();
        $stages = StageAmount::get();



        return view('admin.riders.edit',compact('data','profile','status','stages'));
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
            $input = $request->all();
            $input = $request->except(['stage']);
            $messages = [
                'name.required' => 'Name field is required.',
                'mobile.required' => 'Mobile field is required.',
                
            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'mobile' => 'required|unique:rider_users,mobile,'.$id,
            
            ], $messages);

            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            }
        $data = Rider::find($id);

        
        $data->update($input);


        RiderProfile::where('rider_id',$id)->update(['stage'=>$request->stage]);

        return response()->json(['success' => 'Update item successfully']);
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
