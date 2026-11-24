<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;

class EmergencyAttendanceController extends Controller
{
    /**
     * Download master seluruh siswa dan jadwal aktif.
     */
    public function masterData(Request $request)
    {

        $petugas = auth()->user();

        // Jika bukan petugas QR Code, jangan tarik data siswa
        if (!$petugas || (int) $petugas->is_qrcode !== 1) {
            return response()->json([
                'success' => true,
                'download_required' => false,
                'students' => [],
                'schedules' => [],
                'message' => 'Download data siswa tidak diperlukan.'
            ]);
        }



        $students = DB::table('users')
            ->leftJoin('kelas', 'users.id_kelas', '=', 'kelas.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->select(
                'users.id as student_id',
                'users.name as nama',
                'users.school_id',
                'schools.school_name as sekolah',
                'users.id_kelas',
                'kelas.nama_kelas as kelas',
                'users.location_id'
            )
            ->orderBy('schools.school_name')
            ->orderBy('kelas.nama_kelas')
            ->orderBy('users.name')
            ->get();

        $schedules = DB::table('jadwals')
            ->where('is_active', 1)
            ->select(
                'id as jadwal_id',
                'name',
                'jam_masuk',
                'jam_pulang',
                'is_active'
            )
            ->orderBy('jam_masuk')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'students' => $students,
                'schedules' => $schedules,
            ]
        ]);
    }

    /**
     * Sinkronisasi absensi darurat.
     */
    public function sync(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attendances' => 'required|array|min:1|max:500',

            'attendances.*.uuid' => 'required|uuid',
            'attendances.*.student_id' => 'required|integer',
            'attendances.*.jadwal_id' => 'required|integer',
            'attendances.*.tanggal_masuk' => 'required|date_format:Y-m-d',
            'attendances.*.jam_masuk' => 'required|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        // ID petugas diperoleh dari token login, bukan dari Flutter.
        $petugas = $request->user();

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak terautentikasi.'
            ], 401);
        }

        if ((int) $petugas->is_qrcode !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses absensi darurat.'
            ], 403);
        }



        $hostId = $petugas->id;

        $results = [];
        $successCount = 0;
        $failedCount = 0;

        foreach ($request->attendances as $item) {
            try {
                $result = DB::transaction(function () use ($item, $hostId) {

                    $uuid = $item['uuid'];

                    // Validasi siswa.
                    $student = DB::table('users')
                        ->where('id', $item['student_id'])
                        ->first();

                    if (!$student) {
                        throw new Exception('Siswa tidak ditemukan.');
                    }

                    // Validasi jadwal.
                    $jadwal = DB::table('jadwals')
                        ->where('id', $item['jadwal_id'])
                        ->where('is_active', 1)
                        ->first();

                    if (!$jadwal) {
                        throw new Exception('Jadwal tidak ditemukan atau tidak aktif.');
                    }

                    // BTS hanya jika nama jadwal persis BTS.
                    $isBts = ($jadwal->name === 'BTS');

                    /*
                     * ==================================================
                     * JADWAL BTS
                     * ==================================================
                     */
                    if ($isBts) {

                        $existing = DB::table('bts')
                            ->where('uuid', $uuid)
                            ->first();

                        if ($existing) {
                            return [
                                'uuid' => $uuid,
                                'success' => true,
                                'message' => 'Sudah tersimpan sebelumnya.',
                                'status' => 'already_synced'
                            ];
                        }

                        $waktuMasuk = Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $item['tanggal_masuk'] . ' ' . $item['jam_masuk']
                        );

                        DB::table('bts')->insert([
                            'uuid' => $uuid,
                            'userid' => $student->id,

                            'lat_masuk' => null,
                            'lng_masuk' => null,
                            'lat_pulang' => null,
                            'lng_pulang' => null,

                            'status' => 1,
                            'waktu_masuk' => $waktuMasuk->format('Y-m-d H:i:s'),
                            'waktu_pulang' => null,

                            'keterangan_masuk' => 'Absensi darurat offline',
                            'keterangan_pulang' => null,

                            'catatan_admin_masuk' => 'Absensi darurat offline',
                            'catatan_admin_pulang' => null,

                            'host_masuk' => $hostId,
                            'host_pulang' => null,

                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        return [
                            'uuid' => $uuid,
                            'success' => true,
                            'message' => 'Absensi BTS berhasil disimpan.',
                            'status' => 'synced'
                        ];
                    }

                    /*
                     * ==================================================
                     * JADWAL BIASA
                     * ==================================================
                     */

                    $existing = DB::table('absensis')
                        ->where('uuid', $uuid)
                        ->first();

                    if ($existing) {
                        return [
                            'uuid' => $uuid,
                            'success' => true,
                            'message' => 'Sudah tersimpan sebelumnya.',
                            'status' => 'already_synced'
                        ];
                    }

                    if (!$student->location_id) {
                        throw new Exception(
                            'Siswa belum memiliki lokasi absensi.'
                        );
                    }

                    // Cegah absensi ganda untuk siswa, jadwal dan tanggal yang sama.
                    $duplicate = DB::table('absensis')
                        ->where('user_id', $student->id)
                        ->where('jadwal_id', $jadwal->id)
                        ->where('tanggal_masuk', $item['tanggal_masuk'])
                        ->first();

                    if ($duplicate) {
                        throw new Exception(
                            'Siswa sudah memiliki absensi pada jadwal dan tanggal tersebut.'
                        );
                    }

                    DB::table('absensis')->insert([
                        'uuid' => $uuid,

                        'jadwal_id' => $jadwal->id,
                        'location_id' => $student->location_id,
                        'location_id_pulang' => null,

                        'user_id' => $student->id,
                        'status' => 1,

                        'tanggal_masuk' => $item['tanggal_masuk'],
                        'tanggal_pulang' => null,

                        'jam_masuk' => $item['jam_masuk'],
                        'jam_pulang' => null,

                        'latitude_masuk' => null,
                        'longitude_masuk' => null,
                        'latitude_pulang' => null,
                        'longitude_pulang' => null,

                        'keterangan_masuk' => 'Absensi darurat offline',
                        'keterangan_pulang' => null,

                        'alasan_masuk' => 'Absensi darurat offline',
                        'alasan_pulang' => null,

                        'host_id' => $hostId,
                        'host_id_pulang' => null,

                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    return [
                        'uuid' => $uuid,
                        'success' => true,
                        'message' => 'Absensi berhasil disimpan.',
                        'status' => 'synced'
                    ];
                });

                $results[] = $result;
                $successCount++;
            } catch (Exception $e) {

                $results[] = [
                    'uuid' => $item['uuid'] ?? null,
                    'success' => false,
                    'message' => $e->getMessage(),
                    'status' => 'failed'
                ];

                $failedCount++;
            }
        }

        return response()->json([
            'success' => $failedCount === 0,
            'message' => 'Proses sinkronisasi selesai.',
            'summary' => [
                'total' => count($request->attendances),
                'success' => $successCount,
                'failed' => $failedCount,
            ],
            'data' => $results
        ]);
    }
}
