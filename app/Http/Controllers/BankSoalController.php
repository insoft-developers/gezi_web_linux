<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BankSoal;
use App\BankSoalDetail;
use App\BankSoalSession;
use App\BankSoalAnswer;
use App\User;
use Illuminate\Support\Facades\Cache;

class BankSoalController extends Controller
{
    public function bankSoalAnswerList(Request $request)
    {
        $input = $request->all();
    
        $session = BankSoalSession::findOrFail(
            $input['id_session']
        );
    
        $details = BankSoalDetail::where(
            'id_bank_soal',
            $session->id_bank_soal
        )
        ->orderBy('no_soal', 'asc')
        ->get();
    
        $rows = [];
    
        foreach ($details as $index => $detail) {
    
            // Cari jawaban peserta untuk soal ini
            $jawaban = BankSoalAnswer::where(
                'id_session',
                $input['id_session']
            )
            ->where(
                'id_soal',
                $detail->id
            )
            ->first();
    
            $row = [];
    
            $row['index'] = $index;
            $row['id'] = $detail->id;
            $row['no_soal'] = $detail->no_soal;
    
            // =========================
            // DATA SOAL
            // =========================
    
            $row['soal'] = $detail->soal;
    
            // =========================
            // KUNCI JAWABAN
            // =========================
    
            $row['kunci_jawaban'] =
                $detail->kunci_jawaban;
    
            // =========================
            // DATA JAWABAN PESERTA
            // =========================
    
            if ($jawaban) {
    
                $row['status'] = 1;
    
                $row['jawaban_user'] =
                    $jawaban->jawaban_user;
    
                $row['hasil_jawaban'] =
                    $jawaban->hasil_jawaban;
    
                $row['lama_pengerjaan'] =
                    $jawaban->waktu_selesai;
    
                $row['score'] =
                    $jawaban->score;
    
            } else {
    
                $row['status'] = 0;
    
                $row['jawaban_user'] = null;
    
                $row['hasil_jawaban'] = null;
    
                $row['lama_pengerjaan'] = 0;
    
                $row['score'] = 0;
            }
    
            $rows[] = $row;
        }
    
        return response()->json([
            'success' => true,
            'data' => $rows
        ]);
    }
    
   public function bankSoalHasil(Request $request)
   {
        $input = $request->all();
    
        $query = BankSoalAnswer::where(
            'id_session',
            $input['id_session']
        )
        ->orderBy('id', 'asc')
        ->get();
    
        $session = BankSoalSession::findOrFail(
            $input['id_session']
        );
    
        $id_tryout = $session->id_bank_soal;
        $id_user = $session->id_user;
    
        $tanggal_tryout = date(
            'd-m-Y H:i:s',
            strtotime($session->created_at)
        );
    
        $user = User::findOrFail($id_user);
    
        // Ambil semua detail soal sekaligus
        $details = BankSoalDetail::where(
            'id_bank_soal',
            $id_tryout
        )
        ->get()
        ->keyBy('id');
    
        $total_soal = $details->count();
    
        $tryout = BankSoal::findOrFail(
            $id_tryout
        );
    
        $judul = $tryout->judul;
        $target = $tryout->target_score;
    
        $rows = [];
    
        $totalscore = 0;
        $dijawab = 0;
        $benar = 0;
        $salah = 0;
        $waktu_selesai = 0;
    
        foreach ($query as $index => $d) {
    
            // Cari soal berdasarkan id_soal
            $detail = $details->get($d->id_soal);
    
            // Score
            $totalscore += $d->score;
    
            // Status dijawab
            if ($d->status_jawaban == 1) {
                $dijawab++;
            }
    
            // Benar / salah
            if ($d->hasil_jawaban == 'benar') {
                $benar++;
            } else {
                $salah++;
            }
    
            // Lama pengerjaan
            $lama = $d->waktu_selesai;
    
            $waktu_selesai += $lama;
    
            // =====================================
            // DATA JAWABAN
            // =====================================
    
            $row = [];
    
            $row['id'] = $d->id;
            $row['id_session'] = $d->id_session;
            $row['id_user'] = $d->id_user;
            $row['id_soal'] = $d->id_soal;
            $row['no_soal'] = $d->no_soal;
            
            // SOAL
            $row['soal'] = $detail
                ? $detail->soal
                : '';
            
            // GAMBAR SOAL
            $row['gambar_soal'] = $detail
                ? $detail->gambar_soal
                : null;
            
            // JAWABAN USER
            $row['jawaban_user'] = $d->jawaban_user;
            
            $row['waktu_selesai'] = $d->waktu_selesai;
            $row['status_jawaban'] = $d->status_jawaban;
            $row['hasil_jawaban'] = $d->hasil_jawaban;
            $row['score'] = $d->score;
            $row['lama_pengerjaan'] = $lama;
            
            $row['created_at'] = $d->created_at;
            $row['updated_at'] = $d->updated_at;
    
            $rows[] = $row;
        }
    
        // =====================================
        // KESIMPULAN
        // =====================================
    
        if ($totalscore >= $target) {
            $kesimpulan = 'Lulus';
        } else {
            $kesimpulan = 'Tidak Lulus';
        }
    
        return response()->json([
            'success' => true,
    
            'answer' => $rows,
    
            'user' => $user->name,
    
            'judul' => $judul,
    
            'hasil' => $kesimpulan,
    
            'tanggal' => $tanggal_tryout,
    
            'benar' => $benar,
    
            'salah' => $salah,
    
            'score' => $totalscore,
    
            'target' => $target,
    
            'soal' => $total_soal,
    
            'lewat' => $total_soal - $benar - $salah,
    
            'dijawab' => $dijawab,
    
            'lama' => $waktu_selesai,
        ]);
    }
   
   
    public function bankSoalAnswer(Request $request) {
        $input = $request->all();
       
       
        $bank_soal_id = $input['id_soal'] ; 
        $soal = BankSoalDetail::findorFail($input['id_soal']);
        if($soal->kunci_jawaban == $input['jawaban_user']) {
            $hasil_jawaban = 'benar';
            $score = $soal->score;
        } else {
            $hasil_jawaban = 'salah';
            $score = 0;
        }

        $jwb = BankSoalAnswer::where('id_user', $input['id_user'])
        ->where('id_session', $input['id_session'])
        ->min('waktu_selesai');
        
        $sesi = BankSoalSession::findorFail($input['id_session']);
        $id_bank_soal = $sesi->id_bank_soal;
        
        $bank_soal = BankSoal::findorFail($id_bank_soal);
        $waktu = 120;
        
        if(empty($jwb)) {
            $lama = $waktu - $input['waktu_selesai'];
        } else {
            $lama = $jwb - $input['waktu_selesai'];
        }
       
       
       $jawaban = BankSoalAnswer::where('id_session', $input['id_session'])
                    ->where('id_soal', $input['id_soal']);
       $jawaban_list = $jawaban->get();
       if($jawaban_list->count() > 0){
           $jawaban->delete();
       }
       
       $answer = new BankSoalAnswer;
       $answer->id_session = $input['id_session'];
       $answer->id_user = $input['id_user'];
       $answer->id_soal = $input['id_soal'];
       $answer->no_soal = $input['no_soal'];
       $answer->jawaban_user = $input['jawaban_user'];
       $answer->waktu_selesai = $input['waktu_selesai'];
       $answer->status_jawaban = 1;
       $answer->hasil_jawaban = $hasil_jawaban;
       $answer->score = $score;
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
    
    
    
    public function checkAnswer(Request $request) {
       $input = $request->all();
       $id_soal = $input['id_soal'];
       $id_session = $input['id_session'];
       
       $jawaban = BankSoalAnswer::where('id_soal', $id_soal)
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
    
       
    public function detail($id)
    {
        $cacheKey = 'bank_soal_detail_' . $id;
    
        $rows = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($id) {
    
                $rows = [];
    
                $query = BankSoalDetail::where(
                    'id_bank_soal',
                    $id
                )->get();
    
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
                    $row['youtube_link'] = $key->youtube_link;
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
   
    
    public function addSession(Request $request) {
        $input = $request->all();
        $query = BankSoalSession::create([
                "id_bank_soal" => $input['id_bank_soal'],
                "id_user" => $input['id_user']
            ]);
            
        if($query) {
            return response()->json([
                "success" => true,
                "data" => $query->id
                
            ]);
        }    
    }   
    
    
   public function index(Request $request)
    {
        $idKategori = $request->input('id_kategori');
    
        $cacheKey = 'bank_soal_index_kategori_' . $idKategori;
    
        $rows = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($idKategori) {
    
                $rows = [];
    
                $query = BankSoal::where('id_kategori', $idKategori)
                    ->where('is_active', 1)
                    ->orderBy('urutan', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
    
                foreach ($query as $key) {
    
                    $detail = BankSoalDetail::where(
                        'id_bank_soal',
                        $key->id
                    )->get();
    
                    $row = [];
    
                    $row['id'] = $key->id;
                    $row['judul'] = $key->judul;
                    $row['id_kelas'] = $key->id_kelas;
                    $row['id_kategori'] = $key->id_kategori;
                    $row['is_active'] = $key->is_active;
                    $row['is_skipped'] = $key->is_skipped;
                    $row['is_repeted'] = $key->is_repeated;
                    $row['target_score'] = $key->target_score;
                    $row['created_at'] = $key->created_at;
                    $row['updated_at'] = $key->update_at;
                    $row['jumlah_soal'] = $detail->count();
                    $row['time_limit'] = 'No time limit';
                    $row['warna_soal'] = $key->warna_soal;
                    $row['warna_tulisan'] = $key->warna_tulisan;
                    $row['warna_jawaban'] = $key->warna_jawaban;
                    $row['warna_tulisan_jawaban'] =
                        $key->warna_tulisan_jawaban;
    
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
    
    
    
}
