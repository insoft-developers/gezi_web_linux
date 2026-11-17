<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentBtsController extends Controller
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
     * GET: Riwayat BTS
     */
    public function index(Request $request, $studentId)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $query = DB::table('bts')
            ->leftJoin('users as tutor_masuk', 'bts.host_masuk', '=', 'tutor_masuk.id')
            ->leftJoin('users as tutor_pulang', 'bts.host_pulang', '=', 'tutor_pulang.id')
            ->where('bts.userid', $studentId)
            ->select(
                'bts.*',
                'tutor_masuk.name as nama_host_masuk',
                'tutor_pulang.name as nama_host_pulang'
            );

        // Filter tanggal tertentu
        if ($request->filled('date')) {
            $query->whereDate('waktu_masuk', $request->date);
        }

        // Filter rentang tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('waktu_masuk', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        // Filter bulan dan tahun
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('waktu_masuk', $request->month)
                ->whereYear('waktu_masuk', $request->year);
        }

        $perPage = min(
            max((int) $request->get('per_page', 15), 1),
            100
        );

        $data = $query
            ->orderBy('waktu_masuk', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        $data->getCollection()->transform(function ($item) {
            $item->status_label = $this->statusLabel($item->status);
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Riwayat BTS berhasil diambil.',
            'data' => $data
        ]);
    }

    /**
     * GET: Detail BTS
     */
    public function detail($studentId, $id)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $data = DB::table('bts')
            ->leftJoin('users as tutor_masuk', 'bts.host_masuk', '=', 'tutor_masuk.id')
            ->leftJoin('users as tutor_pulang', 'bts.host_pulang', '=', 'tutor_pulang.id')
            ->where('bts.userid', $studentId)
            ->where('bts.id', $id)
            ->select(
                'bts.*',
                'tutor_masuk.name as nama_host_masuk',
                'tutor_pulang.name as nama_host_pulang'
            )
            ->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data BTS tidak ditemukan.'
            ], 404);
        }

        $data->status_label = $this->statusLabel($data->status);

        return response()->json([
            'success' => true,
            'message' => 'Detail BTS berhasil diambil.',
            'data' => $data
        ]);
    }

    /**
     * GET: Ringkasan BTS
     */
    public function summary(Request $request, $studentId)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $query = DB::table('bts')
            ->where('userid', $studentId);

        // Filter bulan dan tahun
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('waktu_masuk', $request->month)
                ->whereYear('waktu_masuk', $request->year);
        }

        $data = $query->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as belum_absen,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as sudah_masuk,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as sudah_pulang
        ")->first();

        return response()->json([
            'success' => true,
            'message' => 'Ringkasan BTS berhasil diambil.',
            'data' => $data
        ]);
    }
}
