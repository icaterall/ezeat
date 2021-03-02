<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::orderBy('id','DESC')->pluck('name','id')->all();  
         if ($request->ajax()) {

            return  DataTables::of(Role::get())
                    ->addIndexColumn()


            ->addColumn('action', function($row){
                        return  view('admin.roles.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.roles.archive',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $permissions = Permission::orderBy('id','DESC')->pluck('name','id')->all();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                $messages = [
                'name.required' => 'Role name field is required.',
                'name.unique' => 'Role name already exists.'
            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:roles'
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $role = Role::create(['name' => $request->name , 'default' =>0, 'guard_name'=>'web']);
        $role->syncPermissions($request->permission);
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
    
   $permissions = Permission::orderBy('id','DESC')->pluck('name','id')->all();

   $roles = Role::find($id);
   $permissionRole = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
  ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
  
    return view('admin.roles.edit',compact('permissionRole','permissions','roles'));

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

           $messages = [
                'name.required' => 'Role name field is required.',
                'name.unique' => 'Role name already exists.'
            ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:roles,name,'.$id,
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permission);
        return response()->json(array('data' => trans('message.update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          Role::find($id)->delete();  
          return response()->json(['data' => trans('message.delete')]);
    }
}
