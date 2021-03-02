<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Models\Cuisine;

use Carbon\Carbon;
use DB;
use Hash;
use DataTables;
use Auth;
use validate;
use Str;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            return  DataTables::of(Cuisine::get())
                    ->addIndexColumn()
            ->addColumn('action', function($row){
                        return  view('admin.restaurants.cuisines.action-buttons',compact('row'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.restaurants.cuisines.archive');
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
                'name.required' => 'Cuisine name field is required.',
                'name.unique' => 'Cuisine name already exists.'
            ];
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:cuisines'
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data = Cuisine::create($request->all());
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
              $data = Cuisine::findOrFail($id);
      $showForm = view('admin.restaurants.cuisines.form', compact('data'))->render();
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
                'name.required' => 'Cuisine name field is required.',
                'name.unique' => 'Cuisine name already exists.'
            ];
                
            $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:cuisines,name,'.$id,
            ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
   

        $data  = Cuisine::findOrFail($id);
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
       Cuisine::findOrFail($id)->delete();
        return response()->json(array('data' => trans('message.delete')));
    }
}
