<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Session;
class SettingController extends Controller
{
    public function index() {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = "setting";
        $setting = Setting::findorFail(1);
        return view('setting.index', compact('view', 'setting') ); 
    }
    
    public function active($id) {
        $set = Setting::findorFail($id);
        $set->is_register = 1;
        $set->save();
        return response()->json([
           "success" => true 
            
        ]);
    }
    
    
    public function inactive($id) {
        $set = Setting::findorFail($id);
        $set->is_register = 0;
        $set->save();
        return response()->json([
           "success" => true 
            
        ]);
    }
    
    public function setting($id) {
        
        $header = \App\QuizHeader::findorFail($id);
        $quiz = \App\Quiz::where('id_quiz', $id)->get();
        
        return response()->json([
           "success" => true,
           "data" => $header,
           "jumlah_soal"=> $quiz->count(),
           "header" => $header
            
        ]);
    }
    
    public function settingLogin(Request $request) {
        
        return response()->json([
           "success" => true,
           "data" => Setting::findorFail(1),
           "jumlah_soal"=> 0,
           "header" => \App\QuizHeader::where('is_active', 1)->first()
            
        ]);
    }
}
