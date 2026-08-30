<?php

namespace App\Http\Controllers;

use App\Subject;
use App\TryOut;
use App\TryoutAnswer;
use App\TryoutDetail;
use App\TryoutSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TryoutApiV3Controller extends Controller
{
    public function subject(Request $request)
    {
        $data = Subject::where('is_active', 1)->orderBy('urutan')->get();
        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    public function tryout($id, $subjectId)
    {
        $cacheKey = 'tryout_' . $id . '_' . $subjectId;

        $data = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($id, $subjectId) {

                $query = TryOut::where('is_active', 1)
                    ->where('subject_id', $subjectId)
                    ->orderBy('urutan', 'asc')
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

                        $count = TryoutDetail::where('id_tryout', $key->id)
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

    public function tryoutAnswer(Request $request)
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

                $soal = TryoutDetail::findOrFail(
                    $input['id_soal']
                );

                // ==========================================
                // CEK JAWABAN
                // ==========================================

                if (
                    strtolower(trim($soal->kunci_jawaban)) ===
                    strtolower(trim($input['jawaban_user']))
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

                $sesi = TryoutSession::findOrFail(
                    $input['id_session']
                );

                $id_tryout = $sesi->id_tryout;

                // ==========================================
                // AMBIL TRYOUT
                // ==========================================

                $tryout = TryOut::findOrFail(
                    $id_tryout
                );

                $waktu = $tryout->time_limit;

                // ==========================================
                // HAPUS JAWABAN LAMA SOAL INI
                // ==========================================

                TryoutAnswer::where(
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

                $answer = new TryoutAnswer();

                $answer->id_session = $input['id_session'];
                $answer->id_user = $input['id_user'];
                $answer->id_soal = $input['id_soal'];
                $answer->no_soal = $input['no_soal'];
                $answer->jawaban_user = $input['jawaban_user'];

                // Waktu selesai dari Flutter
                $answer->waktu_selesai = $input['waktu_selesai'];

                $answer->status_jawaban = $input['status_jawaban'];
                $answer->hasil_jawaban = $hasil_jawaban;
                $answer->score = $score;
                $answer->init_time = $waktu;

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
