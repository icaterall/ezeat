<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Facades\App\Models\Restaurant;
use Facades\App\DataTables\RestaurantDataTable;
use App\Models\RestaurantWrokingDay;
use Facades\App\Models\RestaurantUser;
use Facades\App\Models\Cuisine;
use Facades\App\Models\RestaurantCuisine;
use Facades\App\Helpers\Helper;
use Facades\App\Models\Food;
use Facades\App\Models\Extra;
use Facades\App\Models\Variation;
use Facades\App\Models\VariationExtra;
use Carbon\Carbon;
use Auth;
use Redirect;


class GeneralSettingController extends Controller
{
   




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_commission()
    {
         return view('admin.setting.commission');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_commission(Request $request)
    {
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes

 $validator = \Validator::make($request->all(), [
                'commission' => 'required|numeric|min:0|max:500'
            ]);

 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            }


          $commission = $request->commission / 100;

           $food_data = Food::all();
           $extras = Extra::all();
           $variations = Variation::all();
           $variationextras = VariationExtra::all();
            foreach ($food_data as $key => $food) {
                $food->update([
                    'price' => $food->restaurant_price + ($food->restaurant_price * $commission)
                ]);
            }
            

            foreach ($variations as $key => $variation_data) {
                 $variation_data->update([
                    'price' => $variation_data->restaurant_price +  ($variation_data->restaurant_price * $commission)
                ]);
             }

          foreach ($extras as $key => $extra_data) {
                 $extra_data->update([
                    'price' => $extra_data->restaurant_price +  ($extra_data->restaurant_price * $commission)
                ]);
             }
           
           foreach ($variationextras as $key => $variationextra_data) {
                 $variationextra_data->update([
                    'price' => $variationextra_data->restaurant_price +  ($variationextra_data->restaurant_price * $commission)
                ]);
             }       

     return response()->json(['success' => 'Update item successfully']);

}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Helper::status();
        $cuisines = Cuisine::orderBy('id','DESC')->pluck('name','id')->all();

        return view('admin.restaurants.all_restaurants.create',compact('status','cuisines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
         if(Auth::user()->hasrole('admin'))
         {  
            $messages = [
                'name.required' => 'Name field is required.',
                'address.required' => 'Address field is required.',
                'latitude.required' => 'Latitude field is required',
                'longitude.required' => 'Longitude field is required',
                'mobile.required' => 'Mobile field is required',
                'mobile.unique' => 'Mobile number already used for other restaurant',
                'preparing_time.required' => 'Cooking time field is required.',
                'min_order.required' => 'Minimum order field is required.',
                'delivery_range.required' => 'Delivery range field is required.',
                'default_tax.required' => 'Tax time field is required.',
                'admin_commission.required' => 'Admin commission is required.'

            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'mobile' => '|unique:restaurants,mobile,'.$id,
                'preparing_time' => 'required|numeric|min:0|max:500',
                'min_order' => 'required|numeric|min:0|max:500',
                'delivery_fee' => 'required|numeric|min:0|max:500',
                'delivery_range' => 'required|numeric|min:0|max:500',
                'default_tax' => 'required|numeric|min:0|max:500',
                'admin_commission' => 'required|numeric|min:0|max:500'
        
            ], $messages);


        } else {

            $messages = [
                'name.required' => 'Name field is required.',
                'address.required' => 'Address field is required.',
                'latitude.required' => 'Latitude field is required',
                'longitude.required' => 'Longitude field is required',
                'mobile.required' => 'Mobile field is required',
                'mobile.unique' => 'Mobile number already used for other restaurant',
                'preparing_time.required' => 'Cooking time field is required.',
                'min_order.required' => 'Minimum order field is required.',

            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'mobile' => '|unique:restaurants,mobile,'.$id,
                'preparing_time' => 'required|numeric|min:0|max:500',
                'min_order' => 'required|numeric|min:0|max:500',
        
            ], $messages);

        }




            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            }
        $data = Restaurant::find($id);
       

         if(Auth::user()->hasrole('manager'))
         { 
           $input['admin_commission'] = $data->admin_commission;
           $input['delivery_fee'] = $data->delivery_fee;
           $input['delivery_range'] = $data->delivery_range;
           $input['default_tax'] = $data->default_tax;
           $input['free_delivery'] = $data->free_delivery;
           $input['accept_cash'] = $data->accept_cash;
           $input['has_riders'] = $data->has_riders;
           $input['available_for_delivery'] = $data->available_for_delivery;
           $input['food_truck'] = $data->food_truck;
         }






        if($input['logo'] == null)
        {
            $input['logo'] = $data->logo;
        }
        
        if($input['banner'] == null)
        {
            $input['banner'] = $data->banner;
        }  

        if($data->foods->first() == null)
        $input['active'] = 0; 
        


        $data->update($input);
       
       if(Auth::user()->hasrole('admin'))

         { 
           
        $commission = $data->admin_commission / 100;

  
            foreach ($data->foods as $key => $food) {
                $food_data = Food::find($food->id);
                $food_data->update([
                    'restaurant_price' => $food_data->price - ($food_data->price * $commission)
                ]);
            }

            foreach ($food_data->variations as $key => $variation_data) {
                 $variation_data->update([
                    'restaurant_price' => $variation_data->price - ($variation_data->price * $commission)
                ]);
                    
             }

          foreach ($food_data->extras as $key => $extra_data) {
                 $extra_data->update([
                    'restaurant_price' => $extra_data->price - ($extra_data->price * $commission)
                ]);
                    
             } 
        
         }




        if($request->input('cuisines') != null)
        $data->cuisines()->sync($request->input('cuisines'));

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
        Restaurant::find($id)->delete();  
        return response()->json(['data' => trans('message.delete')]);
    }
}