<?php

namespace App\Http\Controllers;

use App\BankSoal;
use App\BankSoalDetail;
use App\BankSoalSession;
use App\BankSoalAnswer;
use App\User;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BanksoalApiV3Controller extends Controller
{
    public function bankSoalAnswer(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|array|min:1',
    
            'jawaban.*.id_session' => 'required|integer',
            'jawaban.*.id_user' => 'required|integer',
            'jawaban.*.id_soal' => 'required|integer',
            'jawaban.*.no_soal' => 'required',
            'jawaban.*.jawaban_user' => 'required|string',
            'jawaban.*.waktu_selesai' => 'required|integer',
            'jawaban.*.status_jawaban' => 'required|integer',
        ]);
    
        DB::beginTransaction();
    
        try {
    
            foreach ($request->jawaban as $input) {
    
                // ==========================================
                // AMBIL SOAL
                // ==========================================
    
                $soal = BankSoalDetail::findOrFail(
                    $input['id_soal']
                );
    
                // ==========================================
                // CEK JAWABAN
                // ==========================================
    
                if (
                    strtolower($soal->kunci_jawaban) ===
                    strtolower($input['jawaban_user'])
                ) {
                    $hasil_jawaban = 'benar';
                    $score = $soal->score;
                } else {
                    $hasil_jawaban = 'salah';
                    $score = 0;
                }
    
                // ==========================================
                // SESSION
                // ==========================================
    
                $sesi = BankSoalSession::findOrFail(
                    $input['id_session']
                );
    
                $id_bank_soal = $sesi->id_bank_soal;
    
                $bank_soal = BankSoal::findOrFail(
                    $id_bank_soal
                );
    
                // ==========================================
                // HITUNG LAMA PENGERJAAN
                // ==========================================
    
               
    
                // ==========================================
                // HAPUS JAWABAN LAMA SOAL INI
                // ==========================================
    
                BankSoalAnswer::where(
                    'id_session',
                    $input['id_session']
                )
                ->where(
                    'id_soal',
                    $input['id_soal']
                )
                ->delete();
    
                // ==========================================
                // SIMPAN JAWABAN
                // ==========================================
    
                $answer = new BankSoalAnswer();
    
                $answer->id_session = $input['id_session'];
                $answer->id_user = $input['id_user'];
                $answer->id_soal = $input['id_soal'];
                $answer->no_soal = $input['no_soal'];
                $answer->jawaban_user = $input['jawaban_user'];
                $answer->waktu_selesai = $input['waktu_selesai'];
                $answer->status_jawaban = $input['status_jawaban'];
                $answer->hasil_jawaban = $hasil_jawaban;
                $answer->score = $score;
    
                $answer->save();
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Semua jawaban berhasil disimpan',
                'jumlah' => count($request->jawaban),
            ]);
    
        } catch (\Throwable $e) {
    
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jawaban',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
