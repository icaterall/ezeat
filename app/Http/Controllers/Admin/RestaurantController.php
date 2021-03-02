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


class RestaurantController extends Controller
{
   

    public function uploadRestaurantLogo(Request $request)
    {
     
          if($_FILES["file"]["name"] != '')
            {
             $test = explode('.', $_FILES["file"]["name"]);
             $ext = end($test);
             $name = rand(100, 999) . '.' . $ext;
             $location = './uploads/storelogo/' . $name;  
             move_uploaded_file($_FILES["file"]["tmp_name"], $location);
             return response()->json(['name' => $name]);
            }
    }



    public function uploadRestaurantBanner(Request $request)
    {
     
          if($_FILES["file"]["name"] != '')
            {
             $test = explode('.', $_FILES["file"]["name"]);
             $ext = end($test);
             $name = rand(100, 999) . '.' . $ext;
             $location = './uploads/storeimage/' . $name;  
             move_uploaded_file($_FILES["file"]["tmp_name"], $location);
             return response()->json(['name' => $name]);
            }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
                  if ($request->ajax()) {
            return RestaurantDataTable::dataTable();
            }

         return view('admin.restaurants.all_restaurants.archive');
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
                $input = $request->all();
            $messages = [
                'name.required' => 'Name field is required.',
                'address.required' => 'Address field is required.',
                'latitude.required' => 'Latitude field is required',
                'longitude.required' => 'Longitude field is required',
                'mobile.required' => 'Mobile field is required',
                'mobile.unique' => 'Mobile number already used for other restaurant',
                'preparing_time.required' => 'Cooking time field is required.',
                'min_order.required' => 'Minimum order field is required.',
                'delivery_range.required' => 'Delivery range time field is required.',
                'default_tax.required' => 'Tax time field is required.',
                'banner.required' => 'Banner image is required.'

            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'banner' => 'required',
                'mobile' => '|unique:restaurants,mobile,',
                'preparing_time' => 'required|numeric|min:0|max:500',
                'min_order' => 'required|numeric|min:0|max:500',
                'delivery_fee' => 'required|numeric|min:0|max:500',
                'delivery_range' => 'required|numeric|min:0|max:500',
                'default_tax' => 'required|numeric|min:0|max:500'
        
            ], $messages);
            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
   
        $data = Restaurant::create($input);
        if($request->input('cuisines') != null)
        $data->cuisines()->attach($request->input('cuisines'));       
        // Create store days
        for ($i = 1; $i < 8; $i++) {
            $day = new RestaurantWrokingDay;
            $day->day_id = $i;
            $day->restaurant_id = $data->id;
            $day->available = 1;
            $day->open_time = '08:00';
            $day->close_time = '22:00';
            $day->save();
        }

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
            $data = Restaurant::findOrFail($id);
            $status = Helper::status();
            $cuisine = Restaurant::find($id);
            $RestaurantCuisine = $cuisine->cuisines->pluck('name','id')->all();

       if(Auth::user()->hasrole('admin'))
         return view('admin.restaurants.all_restaurants.edit',compact('data','status','RestaurantCuisine'));
        else if(RestaurantUser::checkRestaurantOwner($id))
        return view('merchants.restaurant.edit',compact('data','status','RestaurantCuisine'));
        return Redirect::route('manager.index')->with('message', 'You do not have permission');  

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
                    'price' => $food_data->restaurant_price +  ($food_data->restaurant_price * $commission)
                ]);
            }

            foreach ($food_data->variations as $key => $variation_data) {
                 $variation_data->update([
                    'price' => $variation_data->restaurant_price +  ($variation_data->restaurant_price * $commission)
                ]);

        $extravariation_data = VariationExtra::where('variation_id',$variation_data->id)->get();
                 
         foreach ($extravariation_data as $key => $extravariation) {
                 $extravariation->update([
                    'price' => $extravariation->restaurant_price +  ($extravariation->restaurant_price * $commission)
                  ]);

              }


             }


          foreach ($food_data->extras as $key => $extra_data) {
                 $extra_data->update([
                    'price' => $extra_data->restaurant_price +  ($extra_data->restaurant_price * $commission)
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