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

class QuizApiV3Controller extends Controller
{

    public function quiz_answer(Request $request)
    {
        $input = $request->validate([
            'jawaban' => 'required|array|min:1',
    
            'jawaban.*.id_quiz' => 'required|integer',
            'jawaban.*.id_user' => 'required|integer',
            'jawaban.*.id_soal' => 'required|integer',
            'jawaban.*.jawaban_user' => 'nullable',
            'jawaban.*.waktu_selesai' => 'nullable',
            'jawaban.*.status_soal' => 'required',
        ]);
    
        $jawaban = $input['jawaban'];
    
        /*
        |--------------------------------------------------------------------------
        | Ambil ID Quiz dan User
        |--------------------------------------------------------------------------
        */
    
        $quizId = $jawaban[0]['id_quiz'];
        $userId = $jawaban[0]['id_user'];
    
        /*
        |--------------------------------------------------------------------------
        | Pastikan semua data berasal dari quiz dan user yang sama
        |--------------------------------------------------------------------------
        */
    
        foreach ($jawaban as $item) {
    
            if (
                $item['id_quiz'] != $quizId ||
                $item['id_user'] != $userId
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data quiz atau user tidak konsisten'
                ], 422);
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | Ambil semua soal sekaligus
        |--------------------------------------------------------------------------
        */
    
        $soalIds = collect($jawaban)
            ->pluck('id_soal')
            ->unique()
            ->values();
    
        $soals = Quiz::whereIn('id', $soalIds)
            ->get()
            ->keyBy('id');
    
        /*
        |--------------------------------------------------------------------------
        | Pastikan semua soal ditemukan
        |--------------------------------------------------------------------------
        */
    
        if ($soals->count() != $soalIds->count()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada soal yang tidak ditemukan'
            ], 422);
        }
    
        /*
        |--------------------------------------------------------------------------
        | Pastikan Quiz Session ada
        |--------------------------------------------------------------------------
        */
    
        $session = QuizSession::findOrFail($quizId);
    
        /*
        |--------------------------------------------------------------------------
        | Siapkan data bulk insert
        |--------------------------------------------------------------------------
        */
    
        $rows = [];
    
        foreach ($jawaban as $item) {
    
            $soal = $soals->get($item['id_soal']);
    
            /*
            |--------------------------------------------------------------------------
            | Cek jawaban
            |--------------------------------------------------------------------------
            */
    
            if ($soal->kunci_jawaban == $item['jawaban_user']) {
    
                $hasilJawaban = 'benar';
                $score = $soal->score;
    
            } else {
    
                $hasilJawaban = 'salah';
                $score = 0;
    
            }
    
            $rows[] = [
                'id_quiz' => $quizId,
                'no_kuis' => $soal->no_kuis,
                'id_user' => $userId,
                'id_soal' => $item['id_soal'],
                'jawaban_user' => $item['jawaban_user'],
                'waktu_selesai' => $item['waktu_selesai'],
                'status_soal' => $item['status_soal'],
                'hasil_jawaban' => $hasilJawaban,
                'score' => $score,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        /*
        |--------------------------------------------------------------------------
        | Simpan ke database
        |--------------------------------------------------------------------------
        */
    
        DB::transaction(function () use ($rows, $quizId, $userId) {
    
            /*
            |--------------------------------------------------------------------------
            | Hapus jawaban lama untuk soal yang dikirim
            |--------------------------------------------------------------------------
            */
    
            $soalIds = collect($rows)
                ->pluck('id_soal')
                ->unique()
                ->values();
    
            // QuizAnswer::where('id_quiz', $quizId)
            //     ->where('id_user', $userId)
            //     ->whereIn('id_soal', $soalIds)
            //     ->delete();
    
            /*
            |--------------------------------------------------------------------------
            | BULK INSERT
            |--------------------------------------------------------------------------
            */
    
            $inserted = QuizAnswer::insert($rows);

            if (!$inserted) {
                throw new \Exception('Bulk insert gagal');
            }
        });
    
        /*
        |--------------------------------------------------------------------------
        | Jalankan proses lanjutan melalui Queue
        |--------------------------------------------------------------------------
        */
    
        // ProsesHasilQuiz::dispatch(
        //     $quizId,
        //     $userId
        // );
    
        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */
    
        return response()->json([
            'success' => true,
            'message' => 'Semua jawaban berhasil disimpan',
            'jumlah' => count($rows),
        ]);
    }
}
