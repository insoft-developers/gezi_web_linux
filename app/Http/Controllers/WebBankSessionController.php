<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\BankSoal;
use App\BankSoalSession;
use App\BankSoalAnswer;
use App\BankSoalDetail;
use App\Kelas;
use App\User;
use Session;
use DB;

class WebBankSessionController extends Controller
{
    public function index() 
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'banksoal-session';
        return view('banksoal.session', compact('view'));
    }
    
    public function ikutBankSoal($id)
    {
        $view = 'banksoal-exam';
        $banksoal = BankSoal::findorFail($id);
        return view('banksoal.exam', compact('view','banksoal'));    
    }
    
    public function bankSoalSessionTable()
    {
        $banksoal = BankSoal::all();
        return Datatables::of($banksoal)
             ->addColumn('id_kelas', function($banksoal){
               $kelasString = $banksoal->id_kelas;
               $kelasArray = explode(",", $kelasString);
               
               $html = "";
               $html .= "<ul>";
               for($i=0; $i < count($kelasArray); $i++) 
               {
                   $id = (int)$kelasArray[$i]; 
                   $kelas = Kelas::findorFail($id);
                   $html .= '<li>'.$kelas->nama_kelas.'</li>';
               }
               $html .= "</ul>";
               
               return '<div>'.$html.'</div>';
           })
            ->addColumn('freq', function($banksoal){
                $fr = BankSoalSession::where('id_bank_soal', $banksoal->id);
                return '<div style="text-align:right;">'.$fr->count().'</div>';
            })
            ->addColumn('is_active', function($banksoal){
               if($banksoal->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
            })
            ->addColumn('target_score', function($banksoal){
                return '<div style="text-align:right;">'.$banksoal->target_score.'</div>';
            })
            ->addColumn('created_at', function($banksoal) {
               return '<center>'.date('d-m-Y', strtotime($banksoal->created_at)).'</center>';
            })
            ->addColumn('action', function($banksoal){
                return '<center><a onclick="listData('. $banksoal->id.')" style="width:25px;margin-right:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
        })->rawColumns(['created_at','target_score','freq','id_kelas','is_active','action'])
        ->make(true);
    }
    
    
    public function bankSoalExamTable($id)
    {
        
        // Subquery: total skor per session
    $scoreSub = DB::table('bank_soal_answers')
        ->select('id_session', DB::raw('SUM(score) as total_score'))
        ->groupBy('id_session');
        
    $durationSub = DB::table('bank_soal_answers')
    ->select('id_session', DB::raw('MAX(waktu_selesai) as max_duration'))
    ->groupBy('id_session');

    // Query utama dengan join semua relasi
        $exam = DB::table('bank_soal_sessions')
        ->leftJoinSub($scoreSub, 'scores', function ($join) {
            $join->on('bank_soal_sessions.id', '=', 'scores.id_session');
        })
        ->leftJoinSub($durationSub, 'durations', function ($join) {
            $join->on('bank_soal_sessions.id', '=', 'durations.id_session');
        })
        ->leftJoin('users', 'users.id', '=', 'bank_soal_sessions.id_user')
        ->leftJoin('schools', 'schools.id', '=', 'users.school_id')
        ->leftJoin('kelas', 'kelas.id', '=', 'users.id_kelas')
        ->leftJoin('locations', 'locations.id', '=', 'users.location_id')
        ->leftJoin('bank_soals', 'bank_soals.id', '=', 'bank_soal_sessions.id_bank_soal')
        ->where('bank_soal_sessions.id_bank_soal', $id)
        ->select([
            'bank_soal_sessions.*',
            'users.name as user_name',
            'users.nis',
            'locations.name as location_name',
            'users.phone',
            'schools.school_name',
            'kelas.nama_kelas',
            'bank_soals.judul as bank_soal_judul',
            'bank_soals.target_score',
            'scores.total_score',
            'durations.max_duration'
        ]);

    return DataTables::of($exam)
        ->addColumn('time', function($exam) {
            $seconds = (int) ($exam->max_duration ?? 0);
            $menit = floor($seconds / 60);
            $detik = $seconds % 60;
        
            return '<div>' . sprintf('%02d:%02d', $menit, $detik) . '</div>';
        })
        ->addColumn('location', function($exam) {
            return '<div>' . ($exam->location_name ?? '-') . '</div>';
        })
        ->addColumn('id_user', function($exam) {
            return '<div>' . ($exam->user_name ?? '-') . '</div>';
        })
        ->addColumn('nis', function($exam) {
            return '<div>' . ($exam->nis ?? '-') . '</div>';
        })
        ->addColumn('phone', function($exam) {
            return '<div>' . ($exam->phone ?? '-') . '</div>';
        })
        ->addColumn('school_id', function($exam) {
            return '<div>' . ($exam->school_name ?? '-') . '</div>';
        })
        ->addColumn('id_kelas', function($exam) {
            return '<div>' . ($exam->nama_kelas ?? '-') . '</div>';
        })
        ->addColumn('judul', function($exam) {
            return '<div>' . ($exam->bank_soal_judul ?? '-') . '</div>';
        })
        ->addColumn('score', function($exam) {
            return '<div style="text-align:right;">' . number_format($exam->total_score ?? 0, 0, ',', '.') . '</div>';
        })
        ->addColumn('target', function($exam) {
            return '<div style="text-align:right;">' . number_format($exam->target_score ?? 0, 0, ',', '.') . '</div>';
        })
        ->addColumn('resume', function($exam) {
            $score = $exam->total_score ?? 0;
            $target = $exam->target_score ?? 0;
            return '<div>' . ($score >= $target ? 'LULUS' : 'TIDAK LULUS') . '</div>';
        })
        ->addColumn('created_at', function($exam) {
            return '<center>' . date('d-m-Y', strtotime($exam->created_at)) . '</center>';
        })
        ->addColumn('detail', function($exam) {
            return '<center><a onclick="listData(' . $exam->id . ')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
        })
        ->rawColumns([
            'id_user', 'nis', 'phone', 'school_id', 'id_kelas',
            'judul', 'score', 'target', 'resume', 'created_at', 'detail','location','time'
        ])
        ->make(true);
   
    }
    
    public function detailExam($id) 
    {
        $answer = BankSoalAnswer::where('id_session', $id)->orderBy('id')->get();
        $ht ='';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach($answer as $index => $key) {
            
            $detail = \App\BankSoalDetail::findorFail($key->id_soal);   
            
            $ht .= '<tr><td>'.$key->no_soal.'</td><td>'.strtoupper($key->jawaban_user).'</td><td>'.strtoupper($detail->kunci_jawaban).'</td><td><center>'.strtoupper($key->hasil_jawaban).'</center></td><td style="text-align:right;">'.$key->score.'</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }
}
