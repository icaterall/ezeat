<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\User;
use Spatie\Permission\Models\Role;
use Facades\App\Models\Restaurant;
use Facades\App\Models\RestaurantUser;
use Facades\App\Helpers\DataTable;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;
class UserController extends Controller
{
   



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
    //Get all Schools and pass it to the view

         if ($request->ajax()) {

            return  DataTables::of(User::get())
                    ->addIndexColumn()

            
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => ($data->created_at) ? with(new Carbon($data->created_at))->format('D n-j-y / h:i a') : '',
                    'timestamp' => ($data->created_at) ? with(new Carbon($data->created_at))->timestamp : '',
                ];
            })
            
            ->addColumn('permission', function ($data) {

               $roles = $data->roles->pluck('name')->all();
               $roles = json_encode($roles); 
               $roles = trim($roles, '[]');
               $roles = trim($roles, '"');
               $roles = str_replace('","',',',$roles);
               if($roles ==null)
                $roles = 'No Role';
               return $roles;
            
            }) 


            ->addColumn('action', function($row){
                        return  view('admin.users.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.users.archive');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    $data=User::findOrFail(Auth::user()->id);
    $status = Helper::status();
    $roles = Role::orderBy('id','DESC')->pluck('name','id')->all();
    $restaurants = Restaurant::orderBy('id','DESC')->pluck('name','id')->all();
    return view('admin.users.create',compact('data','status','roles','restaurants'));

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
                'email.required' => 'Email field is required.',
                'mobile.required' => 'Mobile field is required.',
                'mobile.unique' => 'Mobile already exists.',
                'email.unique' => 'Email already exists.',
                'password.required' => 'Password field is required.'
        ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users',
                'mobile' => 'required|unique:users',
                'password' =>'required'
            ], $messages);
        

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
   

    if ($request->input('restaurants') == null)
    {
       $input = $request->except(['restaurants']);
    } 


    if ($request->input('roles') == null)
    {
       $input = $request->except(['roles']);
    } 



       $input['api_token'] = Str::random(60);

        $input['password'] = Hash::make($input['password']);

        $data = User::create($input);

        if ($request->input('restaurants') != null) { 
            $data->restaurants()->attach($request->input('restaurants'));
            }

        if ($request->input('roles') != null) {  
            $data->assignRole($request->input('roles'));
        }
          return response()->json(['success' => 'Created User successfully']);
}







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    $status = Helper::status();
    $roles = Role::orderBy('id','DESC')->pluck('name','id')->all();
    $data = User::find($id);
    $userRole = $data->roles->pluck('name','id')->all();
    $userRestaurant = $data->restaurants->pluck('name','id')->all();
    
    $restaurants = Restaurant::orderBy('id','DESC')->pluck('name','id')->all();
    return view('admin.users.edit',compact('data','status','roles','restaurants','userRole','userRestaurant'));
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
                'email.required' => 'Email field is required.',
                'mobile.required' => 'Mobile field is required.',
                'mobile.unique' => 'Mobile already exists.',
                'email.unique' => 'Email already exists.',
        ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'mobile' => 'required|unique:users,mobile,'.$id,
            ], $messages);
        



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
   

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            
            $input = $request->except(['password']);  
        }
    
        $user = User::find($id);

        $user->update($input);
       
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        
        if ($request->input('roles') != null)
        {
          $user->assignRole($request->input('roles'));
        }   

    DB::table('user_restaurants')->where('user_id',$id)->delete();
    if ($request->input('restaurants') != null) { 
     $user->restaurants()->attach($request->input('restaurants'));
    }   

        return response()->json(['success' => 'Created User successfully']);

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current_user = Auth::user()->id;
        if($current_user != $id)
        {
          User::find($id)->delete();  
          return response()->json(['data' => trans('message.delete')]);
        }
       
    }
}
