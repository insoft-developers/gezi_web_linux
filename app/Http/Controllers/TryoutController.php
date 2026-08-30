<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TryOut;
use App\TryoutDetail;
use App\TryoutSession;
use App\TryoutAnswer;
use App\User;
use App\TryoutReport;
use Illuminate\Support\Facades\Cache;

class TryoutController extends Controller
{
   public function checkTryout(Request $request) {
       $input = $request->all();
       $tryout = TryoutSession::where('id_tryout', $input['id_tryout'])->where('id_user', $input['id_user'])->get();
       if($tryout->count() > 0) {
           return response()->json([
               "success" => true,
               "session" => $tryout[0]->id
            ]);
       } else {
           return response()->json([
               "success" => false,
               "session" => 0
            ]);
       }
   }
   
   
   public function tryoutAnswerList(Request $request) {
       $input = $request->all();
       $session = TryoutSession::findorFail($input['id_session']);
       
       $details = TryoutDetail::where('id_tryout', $session->id_tryout)->get();
       
       $rows = [];
       
       foreach($details as $index => $detail) {
           $row['index'] = $index;
           $row['id'] = $detail->id;
           $row['no_soal'] = $detail->no_soal;
           
           $jawaban = TryoutAnswer::where('id_session', $input['id_session'])->where('id_soal', $detail->id);
           if($jawaban->count() > 0) {
               $row['status'] = 1;
           } else {
               $row['status'] = 0;
           }
           
           array_push($rows, $row);
       }
       
       return response()->json([
            "success" => true,
            "data" => $rows
       ]);
   }
   
       
   public function checkAnswer(Request $request) {
       $input = $request->all();
       $id_soal = $input['id_soal'];
       $id_session = $input['id_session'];
       
       $jawaban = TryoutAnswer::where('id_soal', $id_soal)
                    ->where('id_session', $id_session)
                    ->first();
       if($jawaban) {
            return response()->json([
               "success" => true,
               "message" => $jawaban->jawaban_user
            ]);
       } else {
            return response()->json([
               "success" => true,
               "message" => 'no-answer'
            ]);
       }                   
   }    
    
   public function tryoutReportAdd(Request $request) {
       $input = $request->all();
       
       $tr = new TryoutReport;
       $tr->id_soal = $input['idSoal'];
       $tr->id_user = $input['idUser'];
       $tr->isi_laporan = $input['isiLaporan'];
       $tr->kategori = $input['kategori'];
       $tr->status = 0;
       $query = $tr->save();
       if($query) {
            return response()->json([
               "success" => true,
               "message" => 'success'
            ]);
       } else {
            return response()->json([
               "success" => false,
               "message" => 'failed'
            ]);
       }
       
   }    
    
   public function tryoutHasil(Request $request) {
       $input = $request->all();
       $query = TryoutAnswer::with('soal')->where('id_session', $input['id_session'])
                ->orderBy('id', 'asc')
                ->get();
       
       $session = TryoutSession::findorFail($input['id_session']);
       $id_tryout = $session->id_tryout;
       $id_user = $session->id_user;
       $tanggal_tryout = date('d-m-Y H:i:s', strtotime($session->created_at));
       
       $user = User::findorFail($id_user);
       
       $total_soal = TryoutDetail::where('id_tryout', $id_tryout)->where('is_active', 1)
                ->get()->count();
       
       
       $tryout = Tryout::findorFail($id_tryout);
       $waktu = $tryout->time_limit;
       $judul = $tryout->judul;
       $target = $tryout->target_score;
       
       $rows = [];
       $totalscore = 0;
       $dijawab = 0;
       $benar = 0;
       $salah = 0;
       $waktu_selesai = 0;
       
       foreach($query  as $index => $d) {
           $totalscore = $totalscore + $d->score;
           
           
           if($index == 0) {
               $lama = $waktu - $d->waktu_selesai;
           } else {
               $lama = $query[$index - 1] -> waktu_selesai - $d->waktu_selesai;
           }
           
           if($d->status_jawaban == 1) {
               $dijawab++;
           }
           
           if($d->hasil_jawaban == 'benar') {
               $benar++;
           } else {
               $salah++;
           }
           
           $waktu_selesai = $waktu_selesai + $lama;
           
           $row['id'] = $d->id;
           $row['id_session'] = $d->id_session;
           $row['id_user'] = $d->id_user;
           $row['id_soal'] = $d->id_soal;
           $row['no_soal'] = $d->no_soal;
           $row['soal'] = optional($d->soal)->soal ?? '';
           $row['gambar_soal'] = optional($d->soal)->gambar_soal ?? '';
           $row['jawaban_user'] = $d->jawaban_user;
           $row['waktu_selesai'] = $d->waktu_selesai;
           $row['status_jawaban'] = $d->status_jawaban;
           $row['hasil_jawaban'] = $d->hasil_jawaban;
           $row['score'] = $d->score;
           $row['created_at'] = $d->created_at;
           $row['updated_at'] = $d->updated_at;
           $row['lama_pengerjaan'] = $lama;
           
           array_push($rows, $row);
       }
       
       if($totalscore >= $target) {
           $kesimpulan = 'Lulus';
       } else {
           $kesimpulan = 'Tidak Lulus';
       }
       
       if($query) {
           return response()->json([
               "success" => true,
               "answer" =>$rows,
               "user" => $user->name,
               "judul" => $judul,
               "hasil" => $kesimpulan,
               "tanggal" => $tanggal_tryout,
               "benar" => $benar,
               "salah" => $salah,
               "score" => $totalscore,
               "target" => $target,
               "soal" => $total_soal,
               "lewat" => $total_soal - $benar - $salah,
               "dijawab" => $dijawab,
               "lama" => $waktu_selesai
           ]);
       }
      
   }    
    
    
   public function tryoutAnswer(Request $request) {
       $input = $request->all();
       
       
        $tryout_id = $input['id_soal'] ; 
        $soal = TryoutDetail::findorFail($input['id_soal']);
        if($soal->kunci_jawaban == $input['jawaban_user']) {
            $hasil_jawaban = 'benar';
            $score = $soal->score;
        } else {
            $hasil_jawaban = 'salah';
            $score = 0;
        }

        $jwb = TryoutAnswer::where('id_user', $input['id_user'])
        ->where('id_session', $input['id_session'])
        ->min('waktu_selesai');
        
        $sesi = TryoutSession::findorFail($input['id_session']);
        $id_tryout = $sesi->id_tryout;
        
        $tryout = TryOut::findorFail($id_tryout);
        $waktu = $tryout->time_limit;
        
        if(empty($jwb)) {
            $lama = $waktu - $input['waktu_selesai'];
        } else {
            $lama = $jwb - $input['waktu_selesai'];
        }
       
       
      $jawaban = TryoutAnswer::where('id_session', $input['id_session'])
                    ->where('id_soal', $input['id_soal']);
      $jawaban_list = $jawaban->get();
      if($jawaban_list->count() > 0){
          $jawaban->delete();
      }
       
       $answer = new TryoutAnswer;
       $answer->id_session = $input['id_session'];
       $answer->id_user = $input['id_user'];
       $answer->id_soal = $input['id_soal'];
       $answer->no_soal = $input['no_soal'];
       $answer->jawaban_user = $input['jawaban_user'];
       $answer->waktu_selesai = $input['waktu_selesai'];
       $answer->status_jawaban = 1;
       $answer->hasil_jawaban = $hasil_jawaban;
       $answer->score = $score;
       $answer->init_time = $waktu;
       $query = $answer->save();
       if($query) {
           return response()->json([
               "success" => true,
               "message" => 'success'
               ]);
       }
       else{
           return response()->json([
               "success" => false,
               "message" => 'failed'
               ]);
       }
       
       
   }        
    
   public function tryoutSession(Request $request) {
        $input = $request->all();
        
        $cek = TryoutSession::where('id_tryout', $input['id_tryout'])
            ->where('id_user', $input['id_user']);
        
        if($cek->count() > 0 ) {
           
        } else {
            $query = TryoutSession::create([
                    "id_tryout" => $input['id_tryout'],
                    "id_user" => $input['id_user']
                ]);
                
            if($query) {
                return response()->json([
                    "success" => true,
                    "data" => $query->id
                    
                    ]);
            }    
        }
        
        
   }   
   
   
   public function detail($id)
    {
        $cacheKey = 'tryout_detail_' . $id;
    
        $rows = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($id) {
    
                $rows = [];
    
                $query = TryoutDetail::where('id_tryout', $id)
                    ->where('is_active', 1)
                    ->get();
    
                foreach ($query as $key) {
    
                    $row = [];
    
                    $row['id'] = $key->id;
                    $row['id_tryout'] = $key->id_tryout;
                    $row['no_soal'] = $key->no_soal;
                    $row['soal'] = $key->soal;
                    $row['gambar_soal'] = $key->gambar_soal;
    
                    $row['jawaban_a'] = $key->jawaban_a;
                    $row['gambar_a'] = $key->gambar_a;
    
                    $row['jawaban_b'] = $key->jawaban_b;
                    $row['gambar_b'] = $key->gambar_b;
    
                    $row['jawaban_c'] = $key->jawaban_c;
                    $row['gambar_c'] = $key->gambar_c;
    
                    $row['jawaban_d'] = $key->jawaban_d;
                    $row['gambar_d'] = $key->gambar_d;
    
                    $row['jawaban_e'] = $key->jawaban_e;
                    $row['gambar_e'] = $key->gambar_e;
    
                    $row['kunci_jawaban'] = $key->kunci_jawaban;
                    $row['score'] = $key->score;
                    $row['is_active'] = $key->is_active;
                    $row['created_at'] = $key->created_at;
                    $row['updated_at'] = $key->updated_at;
    
                    $rows[] = $row;
                }
    
                return $rows;
            }
        );
    
        return response()->json([
            'success' => true,
            'data' => $rows
        ]);
    }
   
   

                
   public function index($id)
    {
        $cacheKey = 'tryout_index_kelas_' . $id;
    
        $data = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($id) {
    
                $query = TryOut::where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();
    
                $data = [];
    
                foreach ($query as $key) {
    
                    $kelas = explode(",", $key->id_kelas);
    
                    $cek = array_search(
                        (string) $id,
                        $kelas,
                        true
                    );
    
                    if ($cek !== false) {
    
                        $count = TryoutDetail::where(
                            'id_tryout',
                            $key->id
                        )
                        ->where('is_active', 1)
                        ->count();
    
                        $row = [];
    
                        $row['id'] = $key->id;
                        $row['judul'] = $key->judul;
                        $row['id_kelas'] = $key->id_kelas;
                        $row['is_active'] = $key->is_active;
                        $row['is_repeated'] = $key->is_repeated;
                        $row['is_skipped'] = $key->is_skipped;
                        $row['time_limit'] = $key->time_limit;
                        $row['target_score'] = $key->target_score;
                        $row['jumlah_soal'] = $count;
                        $row['warna_soal'] = $key->warna_soal;
                        $row['warna_tulisan'] = $key->warna_tulisan;
                        $row['warna_jawaban'] = $key->warna_jawaban;
                        $row['warna_tulisan_jawaban'] =
                            $key->warna_tulisan_jawaban;
    
                        $data[] = $row;
                    }
                }
    
                return $data;
            }
        );
    
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
