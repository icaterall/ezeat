<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\User;
use Facades\App\Models\OrderStatus;
use Facades\App\Models\CancelOrder;
use Facades\App\Models\Coupon;
use Spatie\Permission\Models\Role;
use Facades\App\Models\Food;
use Facades\App\Models\Extra;
use Facades\App\Models\Variation;
use Facades\App\Models\Restaurant;
use Facades\App\Models\ExtraGroup;
use Facades\App\Models\RestaurantUser;
use Facades\App\Models\Category;
use Facades\App\Models\FoodTime;
use File;

use Facades\App\Helpers\DataTable;
use Facades\App\DataTables\VariationDataTable;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;


class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

          if ($request->ajax()) {

         return VariationDataTable::dataTable($request->food_id);
            }

         return view('merchants.foods.sizes.archive');
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
        $input = $request->all();
        $messages = [
                'name.required' => 'Size name field is required.',
                'name.unique' => 'Size name already exists.'
            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'restaurant_price' => 'required|numeric|min:0|max:500'
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
        $input['food_id'] = $request->food_id;
        $restaurant_id = Food::find($request->food_id)->restaurant_id;
        $commission = (Restaurant::find($restaurant_id)->admin_commission) / 100;
        $input['price'] = ($request->restaurant_price * $commission) + $request->restaurant_price;



        $data = Variation::create($input);
        return response()->json(array('data' => trans('message.success')));
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
 
      $size = Variation::findOrFail($id);
      $showSizeForm = view('merchants.foods.sizes.form', compact('size'))->render();
      return response()->json(['showSizeForm' => $showSizeForm]);
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

            $messages = [
                'name.required' => 'Size name field is required.',
            ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'restaurant_price' => 'required|numeric|min:0|max:500'
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $restaurant_id = Food::find($request->food_id)->restaurant_id;
        $commission = (Restaurant::find($restaurant_id)->admin_commission) / 100;
        $input['price'] = ($request->restaurant_price * $commission) + $request->restaurant_price;
        $input['food_id'] = $request->food_id;

        $data  = Variation::findOrFail($id);
        $data->update($input);     
        return response()->json(array('data' => trans('message.success')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          Variation::find($id)->delete();  
          return response()->json(['data' => trans('message.delete')]);
    }
}
