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

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            return  DataTables::of(Permission::get())
                    ->addIndexColumn()
            ->addColumn('action', function($row){
                        return  view('admin.permissions.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.permissions.archive');
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
               $messages = [
                'name.required' => 'Permission name field is required.',
                'name.unique' => 'Permission name already exists.'
            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:permissions'
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = Permission::create($request->all());
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
      $data = Permission::findOrFail($id);
      $showForm = view('admin.permissions.form', compact('data'))->render();
      return response()->json(['showForm' => $showForm]);
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
                'name.required' => 'Permission name field is required.',
                'name.unique' => 'Permission name already exists.'
            ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:permissions,name,'.$id,
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
   

        $data  = Permission::findOrFail($id);
        $data->update($request->all());     
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
        Permission::findOrFail($id)->delete();
        return response()->json(array('data' => trans('message.delete')));
    }
}
