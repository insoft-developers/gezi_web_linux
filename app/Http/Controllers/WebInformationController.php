<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Information;
use Session;
class WebInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'information';
        return view('home.information', compact('view'));
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
        $input['information_image'] = null;
        $unique = uniqid();
        if($request->hasFile('information_image')){
            $input['information_image'] = str_slug($unique, ' - ').'.'.$request->information_image->getClientOriginalExtension();
            $request->information_image->move(public_path('/images/information'), $input['information_image']);
        }

        Information::create($input);

        return response()->json([
            'success'=>true
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
        $info = Information::findorFail($id);
        return $info;
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
        $info = Information::findorFail($id);
        
        $input['information_image'] = $info->information_image;

        if($request->hasFile('information_image')){
            if($info->information_image != NULL){
                unlink(public_path('/images/information/'.$info->information_image));
            }
            
            $unique = uniqid();
            $input['information_image'] = str_slug($unique, ' - ').'.'.$request->information_image->getClientOriginalExtension();
            $request->information_image->move(public_path('/images/information'), $input['information_image']);
        }

        $info->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info=Information::findorFail($id);
        if($info->information_image != NULL){
            unlink(public_path('/images/information/'.$info->information_image));
        }

        Information::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function informationTable()
    {
        $info = Information::all();
        return Datatables::of($info)
           ->addColumn('is_active', function($info){
               if($info->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           ->addColumn('information_image', function($info){
               return '<img style="width:200px;height:120px;border-radius:10px;" src="'.asset('images/information').'/'.$info->information_image.'" >';
           })
            ->addColumn('action', function($info){
                return '<center><a onclick="editData('. $info->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $info->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['is_active','information_image','action'])
        ->make(true);
    
    }
}
