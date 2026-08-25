<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\User;
use App\Admin;
use Session;

class WebAdminController extends Controller
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
        
        if(Session::get('level') != 1) {
            return Redirect(route('default'));
        }
        
        $view = 'admin';
        return view('admin.admin', compact('view'));
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
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $input = $request->all();
        $input['profile_image'] = null;
        $unique = uniqid();
        if($request->hasFile('profile_image')){
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
        }

        $admin = new Admin;
        $admin->name = $input['name'];
        $admin->email = $input['email'];
        $admin->password = bcrypt($input['password']);
        $admin->profile_image = $input['profile_image'];
        $admin->level = $input['level'];
        $admin->created_at = date('Y-m-d H:i:s');
        $admin->save();
        
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
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $admin = Admin::findorFail($id);
        return $admin;
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
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $input = $request->all();
        $admin = Admin::findorFail($id);
        
        $input['profile_image'] = $admin->profile_image;

        if($request->hasFile('profile_image')){
            if($admin->profile_image != NULL){
                unlink(public_path('/storage/images/profil/'.$admin->profile_image));
            }
            
            $unique = uniqid();
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
        }

        $admin->name = $input['name'];
        $admin->email = $input['email'];
        $admin->profile_image = $input['profile_image'];
        if(! empty($input['password']))
        {
            $admin->password = bcrypt($input['password']);
        }
        $admin->level = $input['level'];
        $admin->save();
        
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
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $admin = Admin::findorFail($id);
        if($admin->profile_image != NULL){
            unlink(public_path('/storage/images/profil/'.$admin->profile_image));
        }

        Admin::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function adminTable()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $admin = Admin::all();
        return Datatables::of($admin)
          
           ->addColumn('profile_image', function($admin){
               if(! empty($admin->profile_image)) {
                    return '<img style="width:80px;height:80px;border-radius:40px;border:1px solid grey;" src="'.asset('/storage/images/profil').'/'.$admin->profile_image.'" >';    
               } else {
                   return '<img style="width:80px;height:80px;border-radius:40px;border:1px solid grey;" src="'.asset('/images/playstore.png').'" >';
               }
               
           })
           
           ->addColumn('level', function($admin){
               if($admin->level == 1) {
                    return '<div>Super Admin</div>';    
               } else {
                   return '<div>Admin</div>';
               }
               
           })
           ->addColumn('created_at', function($admin){
               return '<center>'.date('d-m-Y', strtotime($admin->created_at)).'</center>';
           })
            ->addColumn('action', function($admin){
                return '<center><a onclick="editData('. $admin->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $admin->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['level','created_at','profile_image','action'])
        ->make(true);
    
    }
}
