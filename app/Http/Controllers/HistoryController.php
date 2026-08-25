<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuizHeader;
use App\Quiz;
use App\QuizSession;
use App\QuizAnswer;
use App\User;
use App\Kelas;
use App\TryOut;
use App\TryoutDetail;
use App\TryoutSession;
use App\TryoutAnswer;
use App\BankSoal;
use App\BankSoalDetail;
use App\BankSoalAnswer;
use App\BankSoalSession;
use App\TryoutReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;



class HistoryController extends Controller
{

  public function userHistoryList($userid) {
      
        $latestIds = QuizSession::where('user_id', $userid)
            ->selectRaw('MAX(id) as id')
            ->groupBy('id_quiz')
            ->pluck('id');
        
        $latestSessions = QuizSession::with('quiz_answers')
            ->whereIn('id', $latestIds)
            ->get();
        
        $totalScore = $latestSessions->flatMap(function ($session) {
            return $session->quiz_answers;
        })->sum('score');
        
        $totalLama = $latestSessions->flatMap(function ($session) {
            return $session->quiz_answers;
        })->sum('lama_pengerjaan');
        
        $rows = [];
        $data['quiz_score'] = $totalScore;
        $data['quiz_lama'] = $totalLama;
        
        
        $b_latestIds = BankSoalSession::where('id_user', $userid)
            ->selectRaw('MAX(id) as id')
            ->groupBy('id_bank_soal')
            ->pluck('id');
        
        $b_latestSessions = BankSoalSession::with('bank_soal_answers')
            ->whereIn('id', $b_latestIds)
            ->get();
        
        $btotalScore = $b_latestSessions->flatMap(function ($session) {
            return $session->bank_soal_answers;
        })->sum('score');
        
        
        $data['bank_score'] = $btotalScore;
        
        
        $t_latestIds = TryoutSession::where('id_user', $userid)
            ->selectRaw('MAX(id) as id')
            ->groupBy('id_tryout')
            ->pluck('id');
        
        $t_latestSessions = TryoutSession::with('tryout_answers')
            ->whereIn('id', $t_latestIds)
            ->get();
        
        $ttotalScore = $t_latestSessions->flatMap(function ($session) {
            return $session->tryout_answers;
        })->sum('score');
        
        
        $data['tryout_score'] = $ttotalScore;
        
        array_push($rows, $data);
        
        return response()->json([
            "success" => true,
            "data" => $rows
        ]);
      
      
  }
  
  public function QuizWinningList($userid)
    {
        // Cari user dan tingkatnya
        $user = User::with('kelas.tingkat')->find($userid);
    
        if (!$user || !$user->kelas || !$user->kelas->tingkat) {
            return response()->json([
                'success' => false,
                'message' => 'User atau tingkat tidak ditemukan.',
            ], 404);
        }
    
        $tingkatId = $user->kelas->tingkat->id;
    
        // Cache berdasarkan tingkat
        $cacheKey = 'quiz_winning_list_tingkat_' . $tingkatId;
    
        $results = Cache::remember($cacheKey, 300, function () use ($tingkatId) {
    
            // Cari semua user yang satu tingkat
            $userIds = User::whereHas('kelas.tingkat', function ($query) use ($tingkatId) {
                $query->where('id', $tingkatId);
            })->pluck('id');
    
            // Ambil session terakhir per user per quiz
            $latestSessions = DB::table('quiz_sessions')
                ->select(DB::raw('MAX(id) as id'))
                ->whereIn('user_id', $userIds)
                ->groupBy('user_id', 'id_quiz');
    
            // Query ranking
            return DB::table('quiz_sessions')
                ->joinSub($latestSessions, 'latest', function ($join) {
                    $join->on('quiz_sessions.id', '=', 'latest.id');
                })
                ->join(
                    'quiz_answers',
                    'quiz_sessions.id',
                    '=',
                    'quiz_answers.id_quiz'
                )
                ->join(
                    'users',
                    'quiz_sessions.user_id',
                    '=',
                    'users.id'
                )
                ->leftJoin(
                    'schools',
                    'users.school_id',
                    '=',
                    'schools.id'
                )
                ->select(
                    'users.id as userid',
                    'users.name',
                    'users.profile_image as foto',
                    'schools.school_name',
                    DB::raw('SUM(quiz_answers.score) as total'),
                    DB::raw('SUM(quiz_answers.lama_pengerjaan) as lama')
                )
                ->groupBy(
                    'users.id',
                    'users.name',
                    'users.profile_image',
                    'schools.school_name'
                )
                ->orderByDesc('total')
                ->orderBy('lama')
                ->limit(10)
                ->get();
        });
    
        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
   

    
    
  public function BankWinningList($userid)
  {
        try {
            // Cek user & tingkat
            $user = User::with('kelas')->find($userid);
    
            if (!$user || !$user->kelas || !$user->kelas->tingkat_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'User, kelas, atau tingkat tidak ditemukan.'
                ], 404);
            }
    
            $tingkat = $user->kelas->tingkat_id;
    
            // Cache berdasarkan tingkat
            $cacheKey = 'bank_winning_list_tingkat_' . $tingkat;
    
            $sessions = Cache::remember(
                $cacheKey,
                now()->addMinutes(5),
                function () use ($tingkat) {
    
                    // Ambil semua user dalam tingkat tersebut
                    $userIds = User::whereHas('kelas', function ($query) use ($tingkat) {
                        $query->where('tingkat_id', $tingkat);
                    })->pluck('id')->toArray();
    
                    if (empty($userIds)) {
                        return collect();
                    }
    
                    // Ambil ID sesi terakhir per user per bank soal
                    $latestSessionIds = DB::table('bank_soal_sessions')
                        ->select(DB::raw('MAX(id) as id'))
                        ->whereIn('id_user', $userIds)
                        ->groupBy('id_user', 'id_bank_soal')
                        ->pluck('id')
                        ->toArray();
    
                    if (empty($latestSessionIds)) {
                        return collect();
                    }
    
                    // Hitung total score
                    return DB::table('bank_soal_sessions as s')
                        ->select(
                            's.id_user',
                            'u.name',
                            'u.profile_image as foto',
                            'schools.school_name',
                            DB::raw('SUM(a.score) as total')
                        )
                        ->join('users as u', 'u.id', '=', 's.id_user')
                        ->join(
                            'bank_soal_answers as a',
                            'a.id_session',
                            '=',
                            's.id'
                        )
                        ->leftJoin(
                            'schools',
                            'u.school_id',
                            '=',
                            'schools.id'
                        )
                        ->whereIn('s.id', $latestSessionIds)
                        ->groupBy(
                            's.id_user',
                            'u.name',
                            'u.profile_image',
                            'schools.school_name'
                        )
                        ->orderByDesc('total')
                        ->limit(10)
                        ->get();
                }
            );
    
            return response()->json([
                'success' => true,
                'data' => $sessions
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
  
    
   public function TryoutWinningList($userid)
   {
        try {
    
            $user = User::with('kelas')->find($userid);
    
            if (!$user || !$user->kelas || !$user->kelas->tingkat_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'User, kelas, atau tingkat tidak ditemukan.'
                ], 404);
            }
    
            $tingkat = $user->kelas->tingkat_id;
    
            // Cache berdasarkan tingkat
            $cacheKey = 'tryout_winning_list_tingkat_' . $tingkat;
    
            $sessions = Cache::remember(
                $cacheKey,
                now()->addMinutes(5),
                function () use ($tingkat) {
    
                    /*
                    |--------------------------------------------------------------------------
                    | Ambil sesi terakhir setiap user untuk setiap tryout
                    |--------------------------------------------------------------------------
                    */
    
                    $latestSessions = DB::table('tryout_sessions as ts')
                        ->select(
                            'ts.id',
                            'ts.id_user',
                            'ts.id_tryout'
                        )
                        ->join(
                            'users as u',
                            'u.id',
                            '=',
                            'ts.id_user'
                        )
                        ->join(
                            'kelas as k',
                            'k.id',
                            '=',
                            'u.id_kelas'
                        )
                        ->where('k.tingkat_id', $tingkat)
                        ->whereNotExists(function ($query) {
    
                            $query->select(DB::raw(1))
                                ->from('tryout_sessions as newer')
                                ->whereColumn(
                                    'newer.id_user',
                                    'ts.id_user'
                                )
                                ->whereColumn(
                                    'newer.id_tryout',
                                    'ts.id_tryout'
                                )
                                ->whereColumn(
                                    'newer.id',
                                    '>',
                                    'ts.id'
                                );
                        });
    
                    /*
                    |--------------------------------------------------------------------------
                    | Hitung total score
                    |--------------------------------------------------------------------------
                    */
    
                    return DB::table('tryout_answers as a')
                        ->joinSub(
                            $latestSessions,
                            'latest',
                            function ($join) {
                                $join->on(
                                    'latest.id',
                                    '=',
                                    'a.id_session'
                                );
                            }
                        )
                        ->join(
                            'users as u',
                            'u.id',
                            '=',
                            'latest.id_user'
                        )
                        ->leftJoin(
                            'schools',
                            'u.school_id',
                            '=',
                            'schools.id'
                        )
                        ->select(
                            'latest.id_user',
                            'u.name',
                            'u.profile_image as foto',
                            'schools.school_name',
                            DB::raw('SUM(a.score) as total')
                        )
                        ->groupBy(
                            'latest.id_user',
                            'u.name',
                            'u.profile_image',
                            'schools.school_name'
                        )
                        ->orderByDesc('total')
                        ->limit(10)
                        ->get();
                }
            );
    
            return response()->json([
                'success' => true,
                'data' => $sessions
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    
    
    public function quiz($id) {
        $session = QuizSession::where('user_id', $id)
        ->orderBy('id','desc')
        ->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = QuizHeader::findorFail($s->id_quiz);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            $row['waktu_kuis'] = $header->waktu_kuis;
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
        
    }
    
    
    public function tryout($id) {
        $session = TryoutSession::where('id_user', $id)
        ->orderBy('id','desc')
        ->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = TryOut::findorFail($s->id_tryout);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            $row['waktu_kuis'] = $header->time_limit;
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
    
    
    public function banksoal($id) {
        $session = BankSoalSession::where('id_user', $id)
        ->orderBy('id','desc')
        ->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = BankSoal::findorFail($s->id_bank_soal);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
    
    
    
    public function lapor($id) {
        $lapor = TryoutReport::where('id_user', $id)
        ->orderBy('id','desc')
        ->get();
      
        $rows = [];
        foreach($lapor as $s) {
            $user = User::findorFail($id);
            $kelas = Kelas::findorFail($user->id_kelas);
            if($s->kategori == 'tryout') {
                $soal = TryoutDetail::findorFail($s->id_soal);
                $header = TryOut::findorFail($soal->id_tryout);
                $judul = "QUIZ";
            } else {
                $soal = BankSoalDetail::findorFail($s->id_soal);
                $header = BankSoal::findorFail($soal->id_bank_soal);
                $judul = "BANK SOAL";
            }
            
            if($s->status == 0) {
                $status = "Outstanding";
                $selesai = "";
            } else if($s->status == 1) {
                $status = "Finished";
                $selesai = date('d-m-Y', strtotime($s->finish_date));
            }
            
            $row['keterangan'] = strtoupper($judul.' - '.$header->judul.' - Soal No '.$soal->no_soal);
            $row['nama'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['laporan'] = $s->isi_laporan;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['status'] = $status;
            $row['selesai'] = $selesai;
            
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
}
