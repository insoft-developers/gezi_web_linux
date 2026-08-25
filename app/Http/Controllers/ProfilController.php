<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Session;
class ProfilController extends Controller
{
    public function index()
    {
        $view = "profile";
        $admin = Admin::findorFail(Session::get('id'));
        return view('admin.profile', compact('view','admin'));
    }
    
    public function update(Request $request) {
        $input = $request->all();
        $id = $input['id'];
        $admin = Admin::findorFail($id);
        $input['profile_image'] = $admin->profile_image;

        if($request->hasFile('profile_image')){
            if($admin->profile_image != NULL && file_exists(public_path('/storage/images/profil/'.$admin->profile_image))){
                unlink(public_path('/storage/images/profil/'.$admin->profile_image));
            }
            
            $unique = uniqid();
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
            
            
        }
        
        
        $admin->name = $input['name'];
        if(! empty($input['password'])) {
            $admin->password = bcrypt($input['password']);
        }
        
        $admin->profile_image = $input['profile_image'];
        
        $admin->save();
        
        return response()->json(['success'=>true]);
        
    }
}
