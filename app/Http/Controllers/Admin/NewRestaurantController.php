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
use Facades\App\Services\Emails\RestaurantStatusEmail;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use Auth;
use Redirect;
use Session;

class NewRestaurantController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $restaurant = RestaurantUser::where('user_id',auth()->user()->id)->first();
        if($restaurant != null)
        return redirect()->route('merchant.new_restaurant.edit', [$restaurant->restaurant_id])->withSuccess('Thank you for registering with us, we will contact you shortly');
        
        if(Auth::user()->status == 0)
        { 
        Session::flash('success', 'Please activate your mobile number to continue'); 
         return redirect()->route('smsverify');
    }

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
            ];
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'mobile' => '|unique:restaurants,mobile,',
                'email' => '|unique:restaurants,email,',
                'preparing_time' => 'required|numeric|min:0|max:500',
                'min_order' => 'required|numeric|min:0|max:500',
        
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

        Auth::user()->restaurants()->attach($data->id);
        //RestaurantStatusEmail::NewRestaurantEmail($data);
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
            return view('merchants.restaurant.edit',compact('data','status','RestaurantCuisine'));

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


            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            }
        $data = Restaurant::find($id);

           $input['admin_commission'] = $data->admin_commission;
           $input['delivery_fee'] = $data->delivery_fee;
           $input['delivery_range'] = $data->delivery_range;
           $input['default_tax'] = $data->default_tax;
           $input['free_delivery'] = $data->free_delivery;
           $input['accept_cash'] = $data->accept_cash;
           $input['has_riders'] = $data->has_riders;
           $input['available_for_delivery'] = $data->available_for_delivery;
           $input['food_truck'] = $data->food_truck;
         

    
        
        if($input['banner'] == null)
        {
            $input['banner'] = $data->banner;
        }  

        if($data->foods->first() == null)
        $input['active'] = 0; 
        
        $data->update($input);
        
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
