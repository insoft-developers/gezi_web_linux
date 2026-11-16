<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParentAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    /**
     * Login orang tua
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $phone = $this->normalizePhone($request->phone);

        $parent = ParentAccount::where(
            'phone',
            $phone
        )->first();

        if (!$parent || !Hash::check(
            $request->password,
            $parent->password
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor HP atau password salah',
            ], 401);
        }

        if (!$parent->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun orang tua belum aktif',
            ], 403);
        }

        $token = $parent->createToken(
            'parentApp'
        )->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'must_change_password' =>
            (bool) $parent->must_change_password,
            'parent' => [
                'id' => $parent->id,
                'name' => $parent->name,
                'phone' => $parent->phone,
                'school_id' => $parent->school_id,
            ],
        ]);
    }

    /**
     * Daftar anak yang terhubung
     */
    public function children(Request $request)
    {
        $parent = $request->user('parent-api');

        $children = $parent->children()
            ->select([
                'users.id',
                'users.name',
                'users.id_kelas',
                'users.profile_image',
                'users.phone',
                'users.nis',
                'users.school_id',
                'users.class_group',
            ])
            ->with([
                'school:id,school_name',
                'kelas:id,nama_kelas,tingkat_id',
                'kelas.tingkat',
            ])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $children,
        ]);
    }

    /**
     * Mengganti password pertama kali
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $parent = $request->user('parent-api');

        if (!Hash::check(
            $request->old_password,
            $parent->password
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai',
            ], 400);
        }

        $parent->password = Hash::make(
            $request->new_password
        );

        $parent->must_change_password = false;

        $parent->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui',
        ]);
    }

    /**
     * Logout orang tua
     */
    public function logout(Request $request)
    {
        $parent = $request->user('parent-api');

        if ($parent && $parent->token()) {
            $parent->token()->revoke();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Normalisasi nomor HP Indonesia
     */
    private function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        return $phone;
    }


    public function scoreSummary(Request $request, $studentId)
    {
        $parent = $request->user('parent-api');

        // Pastikan siswa merupakan anak dari orang tua yang login
        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        // Gunakan perhitungan dari HistoryController yang sudah ada
        $historyResponse = app(\App\Http\Controllers\HistoryController::class)
            ->userHistoryList($studentId);

        $history = $historyResponse->getData(true);

        $score = $history['data'][0] ?? [];

        return response()->json([
            'success' => true,
            'data' => [
                'student_id' => (int) $studentId,
                'quiz_score' => $score['quiz_score'] ?? 0,
                'quiz_lama' => $score['quiz_lama'] ?? 0,
                'bank_score' => $score['bank_score'] ?? 0,
                'tryout_score' => $score['tryout_score'] ?? 0,
            ],
        ]);
    }


    public function childQuizHistory(Request $request, $studentId)
    {
        $parent = $request->user('parent-api');

        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        return app(\App\Http\Controllers\HistoryController::class)
            ->quiz($studentId);
    }


    public function childBankSoalHistory(Request $request, $studentId)
    {
        $parent = $request->user('parent-api');

        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        return app(\App\Http\Controllers\HistoryController::class)
            ->banksoal($studentId);
    }


    public function childTryoutHistory(Request $request, $studentId)
    {
        $parent = $request->user('parent-api');

        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        return app(\App\Http\Controllers\HistoryController::class)
            ->tryout($studentId);
    }

    public function childQuizDetail($studentId, $sessionId)
    {
        $parent = auth('parent-api')->user();

        // Validasi hubungan orang tua dengan siswa
        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        // Validasi sesi harus milik siswa tersebut
        $session = \App\QuizSession::where('id', $sessionId)
            ->where('user_id', $studentId)
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Riwayat kuis tidak ditemukan.'
            ], 404);
        }

        // Ambil detail jawaban berdasarkan sesi
        $answers = \App\QuizAnswer::where('id_quiz', $sessionId)
            ->where('id_user', $studentId)
            ->orderBy('id_soal', 'asc')
            ->get();

        $rows = [];

        foreach ($answers as $answer) {
            $soal = \App\Quiz::find($answer->id_soal);

            $rows[] = [
                'id' => $answer->id,
                'id_quiz' => $answer->id_quiz,
                'no_kuis' => $answer->no_kuis,
                'id_user' => $answer->id_user,
                'id_soal' => $answer->id_soal,
                'soal' => $soal ? $soal->soal_kuis : '',
                'gambar_soal' => $soal ? $soal->gambar_soal : null,
                'jawaban_a' => $soal ? $soal->jawaban_a : '',
                'jawaban_b' => $soal ? $soal->jawaban_b : '',
                'jawaban_c' => $soal ? $soal->jawaban_c : '',
                'jawaban_d' => $soal ? $soal->jawaban_d : '',
                'jawaban_e' => $soal ? $soal->jawaban_e : '',
                'jawaban_user' => $answer->jawaban_user,
                'hasil_jawaban' => $answer->hasil_jawaban,
                'waktu_selesai' => $answer->waktu_selesai,
                'lama_pengerjaan' => $answer->lama_pengerjaan,
                'score' => $answer->score,
                'status_soal' => $answer->status_soal,
                'created_at' => $answer->created_at,
                'updated_at' => $answer->updated_at,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $rows,
            'message' => 'List Answer'
        ]);
    }


    public function childBankSoalDetail($studentId, $sessionId)
    {
        $parent = auth('parent-api')->user();

        // Pastikan siswa merupakan anak dari akun orang tua
        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        // Pastikan sesi benar-benar milik siswa tersebut
        $session = \App\BankSoalSession::where('id', $sessionId)
            ->where('id_user', $studentId)
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi Bank Soal tidak ditemukan.'
            ], 404);
        }

        $answers = \App\BankSoalAnswer::where('id_session', $sessionId)
            ->where('id_user', $studentId)
            ->orderBy('id_soal', 'asc')
            ->get();

        $rows = [];

        foreach ($answers as $answer) {

            $soal = \App\BankSoalDetail::find($answer->id_soal);

            $rows[] = [
                'id' => $answer->id,
                'id_session' => $answer->id_session,
                'id_user' => $answer->id_user,
                'id_soal' => $answer->id_soal,
                'no_soal' => $answer->no_soal,

                'soal' => $soal ? $soal->soal : '',
                'gambar_soal' => $soal ? $soal->gambar_soal : null,

                'jawaban_a' => $soal ? $soal->jawaban_a : '',
                'gambar_a' => $soal ? $soal->gambar_a : null,

                'jawaban_b' => $soal ? $soal->jawaban_b : '',
                'gambar_b' => $soal ? $soal->gambar_b : null,

                'jawaban_c' => $soal ? $soal->jawaban_c : '',
                'gambar_c' => $soal ? $soal->gambar_c : null,

                'jawaban_d' => $soal ? $soal->jawaban_d : '',
                'gambar_d' => $soal ? $soal->gambar_d : null,

                'jawaban_e' => $soal ? $soal->jawaban_e : '',
                'gambar_e' => $soal ? $soal->gambar_e : null,

                'jawaban_user' => $answer->jawaban_user,
                'hasil_jawaban' => $answer->hasil_jawaban,
                'waktu_selesai' => $answer->waktu_selesai,
                'lama_pengerjaan' => $answer->waktu_selesai,
                'score' => $answer->score,
                'status_jawaban' => $answer->status_jawaban,
                'created_at' => $answer->created_at,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $rows,
            'message' => 'Detail jawaban Bank Soal'
        ]);
    }


    public function childTryoutDetail($studentId, $sessionId)
    {
        $parent = auth('parent-api')->user();

        // Pastikan siswa merupakan anak dari akun orang tua
        $isChild = $parent->children()
            ->where('users.id', $studentId)
            ->exists();

        if (!$isChild) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        // Pastikan sesi benar-benar milik siswa tersebut
        $session = \App\TryoutSession::where('id', $sessionId)
            ->where('id_user', $studentId)
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi Tryout tidak ditemukan.'
            ], 404);
        }

        $answers = \App\TryoutAnswer::where('id_session', $sessionId)
            ->where('id_user', $studentId)
            ->orderBy('no_soal', 'asc')
            ->get();

        $details = [];

        foreach ($answers as $answer) {
            $soal = \App\TryoutDetail::find($answer->id_soal);

            if (!$soal) {
                continue;
            }

            $details[] = [
                'id' => $answer->id,
                'id_soal' => $soal->id,
                'no_soal' => $answer->no_soal,

                'soal' => $soal->soal,
                'gambar_soal' => $soal->gambar_soal,

                'jawaban_a' => $soal->jawaban_a,
                'gambar_a' => $soal->gambar_a,

                'jawaban_b' => $soal->jawaban_b,
                'gambar_b' => $soal->gambar_b,

                'jawaban_c' => $soal->jawaban_c,
                'gambar_c' => $soal->gambar_c,

                'jawaban_d' => $soal->jawaban_d,
                'gambar_d' => $soal->gambar_d,

                'jawaban_e' => $soal->jawaban_e,
                'gambar_e' => $soal->gambar_e,

                // Data jawaban siswa
                'jawaban_user' => $answer->jawaban_user,
                'hasil_jawaban' => $answer->hasil_jawaban,
                'status_jawaban' => $answer->status_jawaban,
                'waktu_selesai' => $answer->waktu_selesai,
                'score' => $answer->score,
                'init_time' => $answer->init_time,
            ];
        }

        return response()->json([
            'success' => true,
            'session_id' => $session->id,
            'student_id' => $studentId,
            'tryout_id' => $session->id_tryout,
            'total_soal' => count($details),
            'total_benar' => collect($details)->where('hasil_jawaban', 'benar')->count(),
            'total_salah' => collect($details)->where('hasil_jawaban', 'salah')->count(),
            'total_score' => collect($details)->sum('score'),
            'data' => $details
        ]);
    }
}
