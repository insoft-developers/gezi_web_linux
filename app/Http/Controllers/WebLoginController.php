<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Session;

class WebLoginController extends Controller
{
    public function index()
    {
        $view = 'login';
        return view('login', compact('view'));
    }
    
    public function proses(Request $request) 
    {
        $input = $request->all();
        $admin = Admin::where('email', $input['loginEmail'])->first();
        $hashedPassword = $admin->password;
         if (Hash::check($input['loginPassword'], $hashedPassword)) {
            Session::put('id', $admin->id);
            Session::put('name', $admin->name);
            Session::put('level', $admin->level);
            Session::put('email', $admin->email);
            return response()->json(['success'=>true]);
         } else {
            return response()->json(['success'=>false]); 
         }
        
    }
    
    public function logout() 
    {
         Session::flush();
         return Redirect(route('login'));
    }
    
    
    public function accountDeletion() {
        return view('account_deletion');
    }
    
    public function sendDeletion(Request $request) {
        $input = $request->all();
        return 'thank you for your request, wi will check your data as soon as posibble';   
    }
    
    
    
    
}
