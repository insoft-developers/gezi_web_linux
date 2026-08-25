<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\TryOut;
use App\Kelas;
use App\TryoutSession;
use App\User;
use App\TryoutAnswer;
use Session;
use DB;
class WebTryoutSessionController extends Controller
{
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'tryout-session';
        return view('tryout.session', compact('view'));
    }
    
    
    public function sessionDetail($id)
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'exam';
        $tryout = TryOut::findorFail($id);
        return view('tryout.exam', compact('view', 'tryout'));
    }
    
    public function detailExam($id) 
    {
        $answer = TryoutAnswer::where('id_session', $id)->orderBy('id')->get();
        $ht ='';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Waktu</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach($answer as $index => $key) {
            
                if($index == 0) {
                    $selisih = $key->init_time - $answer[$index]->waktu_selesai;
                }
                else{
                    $selisih = $answer[$index - 1]->waktu_selesai - $answer[$index]->waktu_selesai;    
                }
                
                $detail = \App\TryoutDetail::findorFail($key->id_soal);
          
            
            $ht .= '<tr><td>'.$key->no_soal.'</td><td>'.strtoupper($key->jawaban_user).'</td><td><center>'.strtoupper($detail->kunci_jawaban).'</center></td><td style="text-align:right";>'.$selisih.' detik</td><td><center>'.strtoupper($key->hasil_jawaban).'</center></td><td style="text-align:right;">'.$key->score.'</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }
    
    public function examTable($id)
    {
        
        $exam = TryoutSession::where('id_tryout', $id)->get();
        return Datatables::of($exam)
         ->addColumn('judul', function($exam){
                $tr = Tryout::findorFail($exam->id_tryout);
                return '<div>'.$tr->judul.'</div>';  
         })
         
         ->addColumn('id_user', function($exam){
             $user = User::find($exam->id_user);
             if($user) {
                 return '<div>'.$user->name.'</div>';
             } else {
                 return '';
             }
             
         })
         ->addColumn('nis', function($exam){
             $user = User::find($exam->id_user);
             if($user) {
                 return '<div>'.$user->nis.'</div>';
             } else {
                 return '';
             }
             
         })
          ->addColumn('phone', function($exam){
             $user = User::find($exam->id_user);
             if($user) {
                 return '<div>'.$user->phone.'</div>';
             } else {
                 return '';
             }
             
         })
          ->addColumn('school_id', function($exam){
             $user = DB::table('users')
                    ->select('users.id', 'schools.school_name')
                    ->where('users.id', $exam->id_user)
                    ->join('schools', 'schools.id', '=', 'users.school_id')
                    ->first();
             
             if($user)
             {
                return '<div>'.$user->school_name.'</div>';   
             } else {
                 return '';
             }
             
         })
         
         ->addColumn('id_kelas', function($exam){
             $user = User::find($exam->id_user);
             if($user) {
                $kelas = Kelas::where('id', $user->id_kelas);
                 if($kelas->count() > 0) {
                    return '<div>'.$kelas->first()->nama_kelas.'</div>';
                 } else {
                    return '';
                 }    
             } else {
                 return '';
             }
             
             
             
         })
         ->addColumn('score', function($exam){
             $sc = TryoutAnswer::where('id_session', $exam->id)->sum('score');
             return '<div style="text-align:right;">'.$sc.'</div>';
         })
         ->addColumn('target', function($exam){
             $tr = TryOut::findorFail($exam->id_tryout);
             return '<div style="text-align:right;">'.$tr->target_score.'</div>';
         })
         ->addColumn('resume', function($exam){
             $tg = TryoutAnswer::where('id_session', $exam->id)->sum('score');
             $tr = TryOut::findorFail($exam->id_tryout);
             $sc = $tr->target_score;
             if($tg >= $sc) {
                 return '<div>LULUS</div>'; 
             } else {
                 return '<div>TIDAK LULUS</div>';
             }
             
             
         })
         ->addColumn('created_at', function($exam){
            return '<center>'.date('d-m-Y', strtotime($exam->created_at)).'</center>';    
         })
         ->addColumn('detail', function($exam){
                return '<center><a onclick="listData('. $exam->id.')" style="width:25px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a><br><a onclick="resetData('. $exam->id.')" style="width:25px;margin-top:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['created_at','target','resume','score','id_kelas','id_user','judul','detail','nis','school_id', 'phone'])
        ->make(true);
    }
    
    
    public function sessionTable()
    {
        $tryout = TryOut::all();
        return Datatables::of($tryout)
            ->addColumn('id_kelas', function($tryout){
               
               $kelas_array = explode(",", $tryout->id_kelas);
               
               $html = '';
               $html .= '<ul>';
               foreach($kelas_array as $k) {
                    $kelas = Kelas::where('id', $k);
                    if($kelas->count() > 0) {
                        $html .= '<li>'.$kelas->first()->nama_kelas.'</li>';
                    }
                    
                    
               }    
                $html .= '</ul>';    
                
                return $html;
            })
            ->addColumn('freq', function($tryout){
                $fr = TryoutSession::where('id_tryout', $tryout->id);
                return '<div style="text-align:right;">'.$fr->count().'</div>';
            })
            ->addColumn('is_active', function($tryout){
               if($tryout->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
            })
            ->addColumn('target_score', function($tryout){
                return '<div style="text-align:right;">'.$tryout->target_score.'</div>';
            })
            ->addColumn('created_at', function($tryout) {
               return '<center>'.date('d-m-Y', strtotime($tryout->created_at)).'</center>';
            })
            ->addColumn('action', function($tryout){
                return '<center><a onclick="listData('. $tryout->id.')" style="width:25px;margin-right:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
        })->rawColumns(['created_at','target_score','freq','id_kelas','is_active','action'])
        ->make(true);
    }
    
    public function resetTryout(Request $request) {
        $input = $request->all();
        
        $query = TryoutSession::destroy($input['id']);
        if($query) {
            TryoutAnswer::where('id_session', $input['id'])->delete();
            return $query;
        }
        
        
    }
}
