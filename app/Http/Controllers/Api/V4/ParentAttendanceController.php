<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentAttendanceController extends Controller
{
    private function isParentOfStudent($studentId)
    {
        $parent = auth('parent-api')->user();

        return $parent && $parent->children()
            ->where('users.id', $studentId)
            ->exists();
    }

    private function statusLabel($status)
    {
        switch ((int) $status) {
            case 0:
                return 'Belum Ada Absen';
            case 1:
                return 'Absen Masuk';
            case 2:
                return 'Absen Pulang';
            default:
                return 'Tidak Diketahui';
        }
    }

    /**
     * GET: Riwayat absensi siswa
     */
    public function index(Request $request, $studentId)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $query = DB::table('absensis')
            ->leftJoin('jadwals', 'absensis.jadwal_id', '=', 'jadwals.id')
            ->leftJoin('locations as lokasi_masuk', 'absensis.location_id', '=', 'lokasi_masuk.id')
            ->leftJoin('locations as lokasi_pulang', 'absensis.location_id_pulang', '=', 'lokasi_pulang.id')
            ->where('absensis.user_id', $studentId)
            ->select(
                'absensis.*',
                'jadwals.name as nama_jadwal',
                'jadwals.jam_masuk as jadwal_jam_masuk',
                'jadwals.jam_pulang as jadwal_jam_pulang',
                'lokasi_masuk.name as nama_lokasi_masuk',
                'lokasi_pulang.name as nama_lokasi_pulang'
            );

        if ($request->filled('date')) {
            $query->whereDate('absensis.tanggal_masuk', $request->date);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('absensis.tanggal_masuk', [
                $request->from,
                $request->to
            ]);
        }

        $perPage = min(max((int) $request->get('per_page', 15), 1), 100);

        $data = $query
            ->orderBy('absensis.tanggal_masuk', 'desc')
            ->orderBy('absensis.id', 'desc')
            ->paginate($perPage);

        $data->getCollection()->transform(function ($item) {
            $item->status_label = $this->statusLabel($item->status);
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Riwayat absensi berhasil diambil.',
            'data' => $data
        ]);
    }

    /**
     * GET: Detail absensi
     */
    public function detail($studentId, $id)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $data = DB::table('absensis')
            ->leftJoin('jadwals', 'absensis.jadwal_id', '=', 'jadwals.id')
            ->leftJoin('locations as lokasi_masuk', 'absensis.location_id', '=', 'lokasi_masuk.id')
            ->leftJoin('locations as lokasi_pulang', 'absensis.location_id_pulang', '=', 'lokasi_pulang.id')
            ->where('absensis.user_id', $studentId)
            ->where('absensis.id', $id)
            ->select(
                'absensis.*',
                'jadwals.name as nama_jadwal',
                'jadwals.jam_masuk as jadwal_jam_masuk',
                'jadwals.jam_pulang as jadwal_jam_pulang',
                'lokasi_masuk.name as nama_lokasi_masuk',
                'lokasi_pulang.name as nama_lokasi_pulang'
            )
            ->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.'
            ], 404);
        }

        $data->status_label = $this->statusLabel($data->status);

        return response()->json([
            'success' => true,
            'message' => 'Detail absensi berhasil diambil.',
            'data' => $data
        ]);
    }

    /**
     * GET: Ringkasan absensi
     */
    public function summary(Request $request, $studentId)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $query = DB::table('absensis')
            ->where('user_id', $studentId);

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('tanggal_masuk', $request->month)
                ->whereYear('tanggal_masuk', $request->year);
        }

        $data = $query->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as belum_absen,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as sudah_masuk,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as sudah_pulang
        ")->first();

        return response()->json([
            'success' => true,
            'message' => 'Ringkasan absensi berhasil diambil.',
            'data' => $data
        ]);
    }
}