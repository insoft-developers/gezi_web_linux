<?php

namespace App\Http\Controllers;
use App\Subject;
use App\TryOut;
use App\TryoutDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
}
