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
use Facades\App\Models\VariationExtra;
use Facades\App\Models\Variation;
use Facades\App\Models\Restaurant;
use Facades\App\Models\ExtraGroup;
use Facades\App\Models\RestaurantUser;
use Facades\App\Models\Category;
use Facades\App\Models\FoodTime;
use File;

use Facades\App\Helpers\DataTable;
use Facades\App\DataTables\ExtraDataTable;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;
use Validator;


class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

          if ($request->ajax()) {

         return ExtraDataTable::dataTable($request->food_id);
            }

         return view('admin.merchants.foods.extras.archive');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function VaryPriceCheck(Request $request)
    {
          if($request->checker == 1)
          {
            $sizes = Variation::where('food_id',$request->food_id)->get();

            $showVariation = view('admin.merchants.foods.extras.vary_price_sizes', compact('sizes'))->render();
           } else
           {
              $showVariation = view('admin.merchants.foods.extras.not_vary_price_sizes')->render();
           }

      return response()->json(['showVariation' => $showVariation]); 
    }
 


    public function create()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewExtra($food_id)
    {
        $restaurant_ids = [];
         foreach(Auth::user()->restaurants as $key => $value)
         {
           $restaurant_ids[] = $value->id;
         }
        
        $foods = Food::whereIn('restaurant_id',$restaurant_ids)->get();
        $food = $foods->find($food_id);
        $data=Extra::where('food_id',$food->id)->get();
        $titles = ExtraGroup::all();
        $sizes = Variation::where('food_id',$food->id)->get();
        return view('admin.merchants.foods.extras.create',compact('data','food','titles','sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
     {
            $messages = [
                'extra_group_id.required' => 'Group name is required.',
                'extra_name.*.required' => 'Extra name is required.',
                'extra_price.*.required' => 'Price is required.',
                'extra_price.*.numeric' => 'Price value is not valid.'
            ];
$error = Validator::make($request->all(), [
           "extra_group_id"    => "required",
           'extra_name.*' => 'required',
            'extra_price.*'  => 'required|numeric|min:0|max:500'
], $messages);


      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      $selection_type = $request->selection_type;
      $extra_name = $request->extra_name;
      $extra_price = $request->extra_price;
      $extra_group_id = $request->extra_group_id;
      $food_id = $request->food_id;
      $restaurant_id = Food::find($food_id)->restaurant_id;
      $commission = (Restaurant::find($restaurant_id)->admin_commission) / 100;
      for($count = 0; $count < count($extra_name); $count++)
      {
       $data = array(
        'selection_type' => $selection_type,
        'name' => $extra_name[$count],
        'extra_group_id' => $extra_group_id,
        'food_id' => $food_id,
        'restaurant_price'  => $extra_price[$count],
        'price' => $extra_price[$count] + ($commission * $extra_price[$count]),
       );      
       Extra::create($data);
      }


      return response()->json([
       'success'  => 'Data Added successfully.'
      ]);
     }
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExtraSize(Request $request)
    {
       if($request->ajax())
     {
         


         $messages = [
                'extra_group_id.required' => 'Group name is required.',
                'extra_name.*.required' => 'Extra name is required.',
                'extra_price.*.*.required' => 'Price is required.',
                'extra_price.*.*.numeric' => 'Price value is not valid.'
            ];
$error = Validator::make($request->all(), [
           "extra_group_id"    => "required",
           'extra_name.*' => 'required',
            'extra_price.*.*'  => 'required|numeric|min:0|max:500'
], $messages);

      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      $selection_type = $request->selection_type;
      $extra_name = $request->extra_name;
      $extra_price = $request->extra_price;
      $extra_group_id = $request->extra_group_id;
      $food_id = $request->food_id;
      $restaurant_id = Food::find($food_id)->restaurant_id;
      $commission = (Restaurant::find($restaurant_id)->admin_commission) / 100;
      $sizes = Variation::where('food_id',$food_id)->get();

      for($count = 0; $count < count($extra_name); $count++)
      {
            $data = array(
        'selection_type' => $selection_type,
        'name' => $extra_name[$count],
        'extra_group_id' => $extra_group_id,
        'food_id' => $food_id,
        'restaurant_price'  => $extra_price[$sizes->first()->id][$count],
        'price' => $extra_price[$sizes->first()->id][$count] + ($commission * $extra_price[$sizes->first()->id][$count]),
         );
               
        $extra_id = Extra::create($data);  

        foreach ($sizes as $key => $size) {
              
        $data_extra = array(
        'extra_id' => $extra_id->id,
        'variation_id' => $size->id,
        'restaurant_price'  => $extra_price[$size->id][$count],
        'price' => $extra_price[$size->id][$count] + ($commission * $extra_price[$size->id][$count]),
         );
              VariationExtra::create($data_extra);
           }   
         }
      return response()->json([
       'success'  => 'Data Added successfully.'
      ]);
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
 
      $extra = Extra::findOrFail($id);
      $sizes = VariationExtra::where('extra_id',$extra->id)->get();

      if(count($sizes)>0)
      {
      $showExtraForm = view('admin.merchants.foods.extras.editsizesform', compact('extra','sizes'))->render();
      $sizes = 1;
      }
      else 
      {
      $showExtraForm = view('admin.merchants.foods.extras.editform', compact('extra'))->render();
      $sizes = 0;
      }

      return response()->json(['showExtraForm' => $showExtraForm,'sizes' => $sizes]);
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
            
       if($request->ajax())
      {
            $input = $request->all();

            $messages = [
                'name.required' => 'Size name field is required.',
            ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'restaurant_price.*' => 'required|numeric|min:0|max:500'
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
   

         if($request->is_size != 1)
         {
            $restaurant_id = Food::find($request->food_id)->restaurant_id;
            $commission = (Restaurant::find($restaurant_id)->admin_commission) / 100;
            $input['price'] = ($request->restaurant_price * $commission) + $request->restaurant_price;
            $input['food_id'] = $request->food_id;
            $data  = Extra::findOrFail($id);
            $data->update($input);
        } 

        else {
        
           $sizes = VariationExtra::where('extra_id',$id)->get();
           $restaurant_id = Food::find($request->food_id)->restaurant_id;
            $commission = (Restaurant::find($restaurant_id)->admin_commission) / 100;
            

          $extra_prices = $request->restaurant_price;

          $input['price'] = ($extra_prices[$sizes->first()->id] * $commission) + $extra_prices[$sizes->
            first()->id];
        
        $input['restaurant_price'] = $extra_prices[$sizes->first()->id];

            $data  = Extra::findOrFail($id);
            $data->update($input);
 
        foreach ($sizes as $key => $size) {

         $data_extra = array(
        'restaurant_price'  => $extra_prices[$size->id],
        'price' => $extra_prices[$size->id] + ($commission * $extra_prices[$size->id]),
         );        
        
        $variation_extradata = VariationExtra::findOrFail($size->id);
        $variation_extradata->update($data_extra);
        
        }  


        }    
        return response()->json(array('data' => trans('message.success')));
      

      }
   
   }


    /**
      * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          Extra::find($id)->delete();  
          return response()->json(['data' => trans('message.delete')]);
    }
}
