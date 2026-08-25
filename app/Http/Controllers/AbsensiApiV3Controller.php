<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absensi;
use App\Location;
use App\User;
use App\Jadwal;

class AbsensiApiV3Controller extends Controller
{
    
    public function status(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['user_id']);
        $absensi = Absensi::where('user_id', $user->id)
            ->where('jadwal_id', $input['jadwal_id'])
            ->latest('id')
            ->first();
            
        if(!$absensi)
        {
            return response()->json([
                "success"=> true,
                "data" => [
                    "status" => 0,
                    "waktu_masuk" => null,
                    "waktu_pulang" => null,
                    "tanggal_masuk" => null,
                    "tanggal_pulang" => null
                
                ]
            ]);
        }
        
        return response()->json([
           "success" => true,
           "data" => [
                "status" => (int) $absensi->status,
                "waktu_masuk" => $absensi->jam_masuk,
                "waktu_pulang" => $absensi->jam_pulang,
                "tanggal_masuk" => $absensi->tanggal_masuk,
                "tanggal_pulang" => $absensi->tanggal_pulang
            ]
        ]);
    }
    
    
    public function jadwal()
    {
        $data = Jadwal::where('is_active', 1)->get();
        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }
    
    
    public function takeQrcode(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['user_id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar.'
            ], 422);
        }
        
        if ($user->is_qrcode == 1) {
            $location = Location::find($user->location_id);
            if (!$location) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi tidak ditemukan.'
                ], 422);
            }   
            
            $data = $location->qrcode;
            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User tidak punya otoritas untuk tampilkan qrcode.'
            ], 422);
        }
        
    }
    
    public function scan(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'user_id'   => 'required|integer',
            'jadwal_id' => 'required|integer',
            'jenis'     => 'required|in:masuk,pulang',
            'qrcode'    => 'required|string',
        
        ]);
    
        $user = User::find($input['user_id']);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar.'
            ], 422);
        }
    
        /*
        |--------------------------------------------------------------------------
        | 1. Ambil lokasi siswa
        |--------------------------------------------------------------------------
        */
    
        $locationId = $user->location_id;
    
        if (!$locationId) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki lokasi.'
            ], 422);
        }
    
        /*
        |--------------------------------------------------------------------------
        | 2. Cari QR Code
        |--------------------------------------------------------------------------
        */
    
        $location = Location::where('qrcode', $request->qrcode)->first();
    
        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah expired.'
            ], 422);
        }
    
        /*
        |--------------------------------------------------------------------------
        | 3. Validasi lokasi
        |--------------------------------------------------------------------------
        */
    
        if ((int) $location->id !== (int) $locationId) {
            return response()->json([
                'success' => false,
                'message' => 'Scan gagal. QR Code bukan untuk lokasi Anda.'
            ], 422);
        }
    
        /*
        |--------------------------------------------------------------------------
        | 4. Cari absensi hari ini
        |--------------------------------------------------------------------------
        */
    
        $tanggal = date('Y-m-d');
    
        $absensi = Absensi::where('jadwal_id', $request->jadwal_id)
            ->where('user_id', $user->id)
            ->where('tanggal_masuk', $tanggal)
            ->first();
    
        /*
        |--------------------------------------------------------------------------
        | 5. MASUK
        |--------------------------------------------------------------------------
        */
    
        if ($request->jenis === 'masuk') {
    
            if ($absensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absen masuk.'
                ], 422);
            }
    
            $absensi = Absensi::create([
                'jadwal_id'     => $request->jadwal_id,
                'location_id'   => $locationId,
                'user_id'       => $user->id,
                'status'        => 1,
                'tanggal_masuk' => $tanggal,
                'jam_masuk'     => date('H:i:s'),
                'latitude_masuk' => $input['latitude'],
                'longitude_masuk' => $input['longitude'],
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil.',
                'data'    => $absensi
            ]);
        }
    
        /*
        |--------------------------------------------------------------------------
        | 6. PULANG
        |--------------------------------------------------------------------------
        */
    
        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk.'
            ], 422);
        }
    
        if ((int) $absensi->status === 2) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen pulang.'
            ], 422);
        }
    
        $absensi->update([
            'status'         => 2,
            'tanggal_pulang' => $tanggal,
            'jam_pulang'     => date('H:i:s'),
            'latitude_pulang' => $input['latitude'],
            'longitude_pulang' => $input['longitude']
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil.',
            'data'    => $absensi
        ]);
    }
}
