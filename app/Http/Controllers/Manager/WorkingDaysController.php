<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantWrokingDay;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use Auth;
use Redirect;

class WorkingDaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = RestaurantWrokingDay::getDaysByRestaurantID($id);
        $restaurant = Restaurant::findOrFail($id);

        return view('merchants.working_days.edit', compact('restaurant', 'data'));
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
        $open_time = $request->input('open_time');
        $close_time = $request->input('close_time');
        $available = $request->input('available');

        foreach ($request->input('day_id') as $key => $value) {
            if (!isset($available[$key])) {
                $available[$key] = 0;
            } else {
                $available[$key] = 1;
            }
    
            RestaurantWrokingDay::updateOrCreate([
                'restaurant_id' => $id,
                'day_id' => $value,
            ], [
                'open_time' => date("H:i", strtotime($open_time[$key])),
                'close_time' => date("H:i", strtotime($close_time[$key])),
                'available' => $available[$key],
            ]);
        }

        return response()->json(['data' => trans('message.success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
