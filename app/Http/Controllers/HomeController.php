<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{
    
    
    
    public function index() {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $view = 'dashboard';
        $siswa = \App\User::where('is_active', 1)->get();
        $tryout = \App\TryOut::where('is_active', 1)->get();
        $banksoal = \App\BankSoal::where('is_active', 1)->get();
        $quiz = \App\QuizHeader::where('is_active', 1)->get();
        return view('dashboard', compact('view','siswa','tryout','banksoal','quiz')); 
    }
    
   
   
}
