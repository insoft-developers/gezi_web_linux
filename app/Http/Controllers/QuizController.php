<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\QuizSession;
use App\QuizAnswer;
use App\Setting;
use App\QuizHeader;
use App\User;
use DB;
use Illuminate\Support\Facades\Cache;

class QuizController extends Controller
{
    public function list($id)
    {
        $cacheKey = 'quiz_list_' . $id;
    
        $list = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($id) {
                return Quiz::where('id_quiz', $id)->get();
            }
        );
    
        return response()->json([
            'success' => true,
            'message' => 'List Quiz',
            'data' => $list
        ]);
    }
    
    
   public function quizList(Request $request)
    {
        $idKelas = $request->input('id_kelas');
    
        $cacheKey = 'quiz_list_kelas_' . $idKelas;
    
        $rows = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($idKelas) {
    
                $kuis = QuizHeader::where('is_active', 1)
                    ->orderBy('urutan', 'asc')
                    ->get();
    
                $rows = [];
    
                foreach ($kuis as $k) {
    
                    $kelas = explode(",", $k->id_kelas);
    
                    $cek = array_search(
                        (string) $idKelas,
                        $kelas,
                        true
                    );
    
                    if ($cek !== false) {
    
                        $row = [];
    
                        $row['id'] = $k->id;
                        $row['judul'] = $k->judul;
                        $row['id_kelas'] = $k->id_kelas;
                        $row['waktu_kuis'] = $k->waktu_kuis;
                        $row['target_score'] = $k->target_score;
                        $row['created_at'] = $k->created_at;
                        $row['updated_at'] = $k->updated_at;
                        $row['is_active'] = $k->is_active;
                        $row['short_name'] = $k->short_name;
                        $row['warna_soal'] = $k->warna_soal;
                        $row['warna_tulisan_soal'] = $k->warna_tulisan_soal;
                        $row['warna_jawaban'] = $k->warna_jawaban;
                        $row['warna_tulisan_jawaban'] =
                            $k->warna_tulisan_jawaban;
    
                        $rows[] = $row;
                    }
                }
    
                return $rows;
            }
        );
    
        return response()->json([
            'success' => true,
            'data' => $rows
        ]);
    }

    
   public function detail($id)
    {
        $answers = QuizAnswer::where('id_quiz', $id)
            ->orderBy('id_soal', 'asc')
            ->get();
    
        $rows = [];
    
        foreach ($answers as $answer) {
    
            // Ambil soal berdasarkan id_soal
            $soal = Quiz::find($answer->id_soal);
    
            $row = [
                'id' => $answer->id,
                'id_quiz' => $answer->id_quiz,
                'no_kuis' => $answer->no_kuis,
                'id_user' => $answer->id_user,
                'id_soal' => $answer->id_soal,
    
                // =========================
                // SOAL
                // =========================
                'soal' => $soal
                    ? $soal->soal_kuis
                    : '',
    
                // =========================
                // GAMBAR SOAL
                // =========================
                'gambar_soal' => $soal
                    ? $soal->gambar_soal
                    : null,
    
                // =========================
                // PILIHAN JAWABAN
                // =========================
                'jawaban_a' => $soal
                    ? $soal->jawaban_a
                    : '',
    
                'jawaban_b' => $soal
                    ? $soal->jawaban_b
                    : '',
    
                'jawaban_c' => $soal
                    ? $soal->jawaban_c
                    : '',
    
                'jawaban_d' => $soal
                    ? $soal->jawaban_d
                    : '',
    
                'jawaban_e' => $soal
                    ? $soal->jawaban_e
                    : '',
    
                // =========================
                // JAWABAN USER
                // =========================
                'jawaban_user' => $answer->jawaban_user,
    
                // =========================
                // HASIL
                // =========================
                'hasil_jawaban' => $answer->hasil_jawaban,
    
                // =========================
                // WAKTU
                // =========================
                'waktu_selesai' => $answer->waktu_selesai,
    
                'lama_pengerjaan' => $answer->waktu_selesai,
    
                // =========================
                // SCORE
                // =========================
                'score' => $answer->score,
    
                'status_soal' => $answer->status_soal,
    
                'created_at' => $answer->created_at,
                'updated_at' => $answer->updated_at,
            ];
    
            $rows[] = $row;
        }
    
        return response()->json([
            'success' => true,
            'data' => $rows,
            'message' => 'List Answer'
        ]);
    }
    
    public function add_session(Request $request) {
        $input = $request->all();

        $quiz = new QuizSession;
        $quiz->user_id = $input['user_id'];
        $quiz->id_quiz = $input['id_quiz'];
        $quiz->save();
        return response()->json([
           'success' => true,
           'session_quiz' => $quiz->id,
       ]);

    }


    public function quiz_answer(Request $request) {
        $input = $request->all();

        $quiz_id = $input['id_quiz'] ; 
        $soal = Quiz::findorFail($input['id_soal']);
        $no_kuis = $soal->no_kuis;
        
        $session = QuizSession::findorFail($quiz_id);
        $idkuis = $session->id_quiz;
        if($soal->kunci_jawaban == $input['jawaban_user']) {
            $hasil_jawaban = 'benar';
            $score = $soal->score;
        } else {
            $hasil_jawaban = 'salah';
            $score = 0;
        }

        $jwb = QuizAnswer::where('id_user', $input['id_user'])
        ->where('id_quiz', $quiz_id)
        ->min('waktu_selesai');
        
        $setting = QuizHeader::where('id', $idkuis)->first();
        
        $waktu = $setting->waktu_kuis;
        
        
        
        if(empty($jwb)) {
            $lama = $waktu - $input['waktu_selesai'];
        } else {
            $lama = $jwb - $input['waktu_selesai'];
        }
        
        
        
        $cek = QuizAnswer::where('id_quiz', $quiz_id)
            ->where('no_kuis', $no_kuis)
            ->where('id_user', $input['id_user']);
            
        if($cek->count() > 0) {
            $cek->delete();
        }    

        $quiz = new QuizAnswer;
        $quiz->id_quiz = $quiz_id;
        $quiz->no_kuis = $no_kuis;
        $quiz->id_user = $input['id_user'];
        $quiz->id_soal = $input['id_soal'];
        $quiz->jawaban_user = $input['jawaban_user'];
        $quiz->waktu_selesai = $input['waktu_selesai'];
        $quiz->status_soal = $input['status_soal'];
        $quiz->hasil_jawaban = $hasil_jawaban;
        $quiz->lama_pengerjaan = $input['waktu_selesai'] ?? '';
        $quiz->score = $score;
        $quiz->save();
        if($quiz) {
            return response()->json([
                'success' => true,
                'message' => 'sukses'
            ]);    
        } else {
            return response()->json([
                'success' => false,
                'message' => 'failed'
            ]);
        }
        
    }
    
    
    
    // public function quiz_answer(Request $request)
    // {
    //     $input = $request->all();
    
    //     $quiz_id = $input['id_quiz'];
    //     $id_user = $input['id_user'];
    //     $id_soal = $input['id_soal'];
    
    //     // Cache soal
    //     $soal = Cache::remember(
    //         'quiz_soal_' . $id_soal,
    //         3600,
    //         function () use ($id_soal) {
    //             return Quiz::findOrFail($id_soal);
    //         }
    //     );
    
    //     $no_kuis = $soal->no_kuis;
    
    //     // Session
    //     $session = QuizSession::findOrFail($quiz_id);
    
    //     if ($soal->kunci_jawaban == $input['jawaban_user']) {
    //         $hasil_jawaban = 'benar';
    //         $score = $soal->score;
    //     } else {
    //         $hasil_jawaban = 'salah';
    //         $score = 0;
    //     }
    
    //     // Hapus jawaban sebelumnya tanpa count()
    //     QuizAnswer::where('id_quiz', $quiz_id)
    //         ->where('no_kuis', $no_kuis)
    //         ->where('id_user', $id_user)
    //         ->delete();
    
    //     // Simpan jawaban
    //     $quiz = new QuizAnswer();
    
    //     $quiz->id_quiz = $quiz_id;
    //     $quiz->no_kuis = $no_kuis;
    //     $quiz->id_user = $id_user;
    //     $quiz->id_soal = $id_soal;
    //     $quiz->jawaban_user = $input['jawaban_user'];
    //     $quiz->waktu_selesai = $input['waktu_selesai'];
    //     $quiz->status_soal = $input['status_soal'];
    //     $quiz->hasil_jawaban = $hasil_jawaban;
    //     $quiz->score = $score;
    
    //     $quiz->save();
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'sukses'
    //     ]);
    // }
    
    

    public function quiz_hasil(Request $request) {

        $input = $request->all();
       
        $idquiz = $input['id_quiz'];
        
        $sesi = QuizSession::findorFail($idquiz);        
        $idkuis = $sesi->id_quiz;
        $iduser = $sesi->user_id;
        
        $user = User::findorFail($iduser);
        
        $header = QuizHeader::where('id', $idkuis)->first();
        
        $soal = Quiz::where('id_quiz', $idkuis)->count();

        $data = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->get();

        
        
        $score = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->sum('score');
        
        $lama = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->sum('waktu_selesai');

        $benar = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->where('hasil_jawaban', 'benar')
        ->get(); 

        $salah = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->where('hasil_jawaban', 'salah')
        ->get();
        
        if($score < $header->target_score) {
            $grade = 'TIDAK LULUS';
        }
        else {
            $grade = 'LULUS';    
        }
        
        $list['judul'] = $header->judul;
        $list['benar'] = $benar->count();
        $list['salah'] = $salah->count();
        $list['lewat'] = $soal - $benar->count() - $salah->count();
        $list['total'] = $soal;
        $list['tanggal'] = date('d-m-Y H:i:s', strtotime($sesi->created_at));
        $list['lama']  = $lama;
        $list['target'] = $header->target_score;
        $list['score'] = $score;
        $list['grade'] = $grade;
        $list['nama'] = $user->name;

        if($data) {
            return response()->json([
                "success"=> true,
                "data"=> $list

            ]);
        }    
    
    }
    
    
    
    
}
