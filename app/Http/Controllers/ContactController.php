<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    
    public function checkActiveUser(Request $request)
    {
        try {
            $input = $request->all();
            $id = (int)$input['id_user'];
            $user = \App\User::findorFail($id);
            
            $sekarang = date('Y-m-d H:i:s');
            $user->last_activity = $sekarang;
            $user->version = $input['version'];
            $user->save();
            
            return response()->json([
               "success" => true,
               "data" => $user
            ]);
        } catch(\Exception $e) {
            $user['is_active'] = "0";
            return response()->json([
               "success" => true,
               "data" => $user
            ]);
        }
    }
    
    public function add(Request $request)
    {
        $input = $request->all();
        
        $contact = new Contact;
        $contact->id_user = $input['id_user'];
        $contact->name = $input['name'];
        $contact->phone_number = $input['phone_number'];
        $contact->urutan = $input['urutan'];
        $contact->save();
        
        return response()->json([
           "success" => true 
        ]);
    }
    
    public function cekUrutan(Request $request) 
    {
        $input = $request->all();
        $data = Contact::where('id_user', $input['id_user']);
        if($data->get()->count() > 0) {
          $hasil = $data->max('urutan');    
        } else {
          $hasil = 0;    
        }
        
        
        return response()->json([
           "success" => true,
           "urutan" => (int)$hasil
        ]); 
    }
}
