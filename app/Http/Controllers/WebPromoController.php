<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Promo;
use Session;

class WebPromoController extends Controller
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
        $view = 'promo';
        return view('home.promo', compact('view'));
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
        $input['promo_image'] = null;
        $unique = uniqid();
        if($request->hasFile('promo_image')){
            $input['promo_image'] = str_slug($unique, ' - ').'.'.$request->promo_image->getClientOriginalExtension();
            $request->promo_image->move(public_path('/images/promo'), $input['promo_image']);
        }

        Promo::create($input);

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
        $promo = Promo::findorFail($id);
        return $promo;
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
        $promo = Promo::findorFail($id);
        
        $input['promo_image'] = $promo->promo_image;

        if($request->hasFile('promo_image')){
            if($promo->promo_image != NULL){
                unlink(public_path('/images/promo/'.$promo->promo_image));
            }
            
            $unique = uniqid();
            $input['promo_image'] = str_slug($unique, ' - ').'.'.$request->promo_image->getClientOriginalExtension();
            $request->promo_image->move(public_path('/images/promo'), $input['promo_image']);
        }

        $promo->update($input);
        
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
        $promo=Promo::findorFail($id);
        if($promo->promo_image != NULL){
            unlink(public_path('/images/promo/'.$promo->promo_image));
        }

        Promo::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function promoTable()
    {
        $promo = Promo::all();
        return Datatables::of($promo)
           ->addColumn('is_active', function($promo){
               if($promo->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           ->addColumn('promo_image', function($promo){
               return '<img style="width:200px;height:120px;border-radius:10px;" src="'.asset('images/promo').'/'.$promo->promo_image.'" >';
           })
            ->addColumn('action', function($promo){
                return '<center><a onclick="editData('. $promo->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $promo->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['is_active','promo_image','action'])
        ->make(true);
    
    }
}
