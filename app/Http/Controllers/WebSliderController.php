<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Slider;
use Session;

class WebSliderController extends Controller
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
        $view = 'slider';
        return view('home.slider', compact('view'));
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
        $input['slider_image'] = null;
        $unique = uniqid();
        if($request->hasFile('slider_image')){
            $input['slider_image'] = str_slug($unique, '-').'.'.$request->slider_image->getClientOriginalExtension();
            $request->slider_image->move(public_path('/images/slider'), $input['slider_image']);
        }

        Slider::create($input);

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
        $slider = Slider::findorFail($id);
        return $slider;
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
        $slider = Slider::findorFail($id);
        
        $input['slider_image'] = $slider->slider_image;

        if($request->hasFile('slider_image')){
            if($slider->slider_image != NULL){
                unlink(public_path('/images/slider/'.$slider->slider_image));
            }
            
            $unique = uniqid();
            $input['slider_image'] = str_slug($unique, ' - ').'.'.$request->slider_image->getClientOriginalExtension();
            $request->slider_image->move(public_path('/images/slider'), $input['slider_image']);
        }

        $slider->update($input);
        
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
        $slider=Slider::findorFail($id);
        if($slider->slider_image != NULL){
            unlink(public_path('/images/slider/'.$slider->slider_image));
        }

        Slider::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function sliderTable()
    {
        $slider = Slider::all();
        return Datatables::of($slider)
           ->addColumn('is_active', function($slider){
               if($slider->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           ->addColumn('slider_image', function($slider){
               return '<img style="width:200px;height:120px;border-radius:10px;" src="'.asset('images/slider').'/'.$slider->slider_image.'" >';
           })
            ->addColumn('action', function($slider){
                return '<center><a onclick="editData('. $slider->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $slider->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['is_active','slider_image','action'])
        ->make(true);
    
    }
}
