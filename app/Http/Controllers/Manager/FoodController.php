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
use Facades\App\DataTables\FoodDataTable;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
          if ($request->ajax()) {
            return FoodDataTable::dataTable();
            }

         return view('merchants.foods.archive');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant_ids = [];
         foreach(Auth::user()->restaurants as $key => $value)
         {
           $restaurant_ids[] = $value->id;
         }
        $status = Helper::status();
        $restaurants = Restaurant::whereIn('id',$restaurant_ids)->pluck('name','id');
        $times = FoodTime::orderBy('id','DESC')->pluck('name','id')->all();
        $categories = Category::orderBy('name','asc')->pluck('name','id')->all();
   
        return view('merchants.foods.create',compact('restaurants','status','categories','times'));
    }


    public function uploadFoodImage(Request $request)
    {
     
          if($_FILES["file"]["name"] != '')
            {
             $test = explode('.', $_FILES["file"]["name"]);
             $ext = end($test);
             $name = rand(100, 999) . '.' . $ext;
             $location = './uploads/productimages/' . $name;  
             move_uploaded_file($_FILES["file"]["tmp_name"], $location);
             return response()->json(['name' => $name]);
            }
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
                'restaurant_price.required' => 'Restaurant field is required.',
                'category_id.required' => 'Category field is required',
                'restaurant_id.required' => 'Restaurant field is required',
        ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'restaurant_price' => 'required|numeric|min:0|max:500',
                'category_id' => 'required',
                'restaurant_id.required' => 'Restaurant field is required.',

                
            ], $messages);

            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


      if ($request->expires_at != null) {

            $expires_at = strtotime($request->expires_at);
            $expires_at = date('Y-m-d H:i:s', $expires_at);
            $input['expires_at'] = $expires_at;

        }

        $commission = (Restaurant::find($request->restaurant_id)->admin_commission) / 100;
        $input['price'] = ($request->restaurant_price * $commission) + $request->restaurant_price;
        $data = Food::create($input);
       $data->times()->attach($request->input('times'));

       $url = '/manager_gate/foods/'.$data->id.'/edit';


        return response()->json([
            'success' => 'Created item successfully',
            'url' => $url,
    ]);
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
         $restaurant_ids = [];
         foreach(Auth::user()->restaurants as $key => $value)
         {
           $restaurant_ids[] = $value->id;
         }

        $data=Food::findOrFail($id);
        $status = Helper::status();
        $restaurants = Restaurant::whereIn('id',$restaurant_ids)->pluck('name','id');
        $foodIds = Food::where('restaurant_id',$data->restaurant_id)->pluck('id');
        $extras = Extra::whereIn('food_id',$foodIds)->pluck('name','restaurant_price','id');
        $variations = Variation::whereIn('food_id',$foodIds)->pluck('name','restaurant_price','id');
        $groups = ExtraGroup::orderBy('name','asc')->pluck('name','id')->all();
        $categories = Category::orderBy('name','asc')->pluck('name','id')->all();
        $foodTime = $data->times->pluck('name','id')->all();
        $times = FoodTime::orderBy('id','DESC')->pluck('name','id')->all();

        return view('merchants.foods.edit',compact('data','restaurants','status','extras','variations','groups','categories','foodTime','times'));
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
                'restaurant_price.required' => 'Restaurant field is required.',
                'category_id.required' => 'Category field is required',
            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'restaurant_price' => 'required|numeric|min:0|max:500',
                'category_id' => 'required'
            
            ], $messages);

            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            }
        $data = Food::find($id);
        
       
        if($input['image'] == null)
        {
            $input['image'] = $data->image;
        }
        
        
        $commission = (Restaurant::find($request->restaurant_id)->admin_commission) / 100;
        $input['price'] = ($request->restaurant_price * $commission) + $request->restaurant_price;
        
        $data->update($input);
        $data->times()->attach($request->input('times'));
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
         Food::find($id)->delete();  
          return response()->json(['data' => trans('message.delete')]);
    }
}
