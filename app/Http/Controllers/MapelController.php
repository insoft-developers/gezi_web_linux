<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mapel;
use App\Bimbingan;
use DB;
use App\Comment;
use App\Like;
use App\Kelas;
use App\User;
use App\MateriPembelajaran;
use App\KategoriVideo;
use App\TobkVideo;
class MapelController extends Controller
{
    
    public function tobkVideoList(Request $request) {
        $input = $request->all();
        $query = TobkVideo::where('id_kategori', $input['id_kategori']);
        
        if($query) {
            return response()->json([
               "success" => true,
               "data" => $query->get()
            ]);        
        } else {
            return response()->json([
               "success" => false,
               "data" => []
            ]);
        }
    }
    
    
    public function tobkList(Request $request) {
        $input = $request->all();
        $query = KategoriVideo::where('id_kelas', $input['id_kelas']);
        if($query) {
            return response()->json([
               "success" => true,
               "data" => $query->get()
            ]);
        } else {
            return response()->json([
               "success" => false,
               "data" => []
            ]);
        }
    }
    
       
    public function testing() {
        $users = Kelas::all();
       
        $data = [];
        
      
        foreach($users as $user) {
            array_push($data, $user->user()->id);
        }
        
        return $users;
    }
    
    public function index(Request $request) {
        $input = $request->all();
        $ids = $input['id_kelas'];
        $id = (string)$ids;
        $rows = [];
        $mapel = Mapel::where('is_active', 1)->orderBy('urutan', 'asc')->get();
        foreach($mapel as $m) {
            $kelasArray = explode(",", $m->id_kelas);
            $kelascek = array_search($id, $kelasArray, true);
            
            if($kelascek !== false)
            {
                $row['id'] = $m->id;
                $row['mapel_name'] = $m->mapel_name;
                $row['mapel_image'] = $m->mapel_image;
                $row['created_at'] = $m->created_at;
                $row['updated_at'] = $m->updated_at;
                $row['status'] = $m->status;
                $row['id_kelas'] = $m->id_kelas;
                
                array_push($rows , $row);
            }
            
        }
        
        
        return response()->json([
            'success'=> true,
            'data' => $rows
            ]);
    }
    
    
    
    public function mapelListForBankSoal(Request $request) {
        
        $input = $request->all();
        
        $rows = [];
        $mapel = Mapel::where('is_active', 1)->get();
        foreach($mapel as $m) {
            $kelas = explode(",", $m->id_kelas);
            $idkelas = (string)$input['id_kelas'];
            
            $cek = array_search($idkelas, $kelas, true);
            if($cek !== false) {
                $row['id'] = $m->id;
                $row['mapel_name'] = $m->mapel_name;
                $row['mapel_image'] = $m->mapel_image;
                $row['created_at'] = $m->created_at;
                $row['updated_at'] = $m->updated_at;
                $row['status'] = $m->status;
                
                array_push($rows , $row);    
            }
            
        }
        
        return response()->json([
            'success'=> true,
            'data' => $rows
            ]);
    }
    
    
    
    
    public function likePost(Request $request) {
        $input = $request->all();
        $type = $input['type'];
        $userid = $input['id_user'];
        $idtype = $input['id_type'];
        
        $cek = Like::where('type', $type)
                ->where('id_user', $userid)
                ->where('id_type', $idtype)
                ->get();
                
        if($cek->count() > 0 ) {
            if($type == 'bimbingan') {
                    Bimbingan::where('id',$idtype)->decrement('is_liked');
                    Like::where('id_type', $idtype)
                            ->where('type', $type)
                            ->delete();
                    
            } else if($type == 'tobk') {
                    TobkVideo::where('id',$idtype)->decrement('is_liked');
                    Like::where('id_type', $idtype)
                            ->where('type', $type)
                            ->delete();
            }
        } else {
            $like = new Like;
            $like->type = $type;
            $like->id_type = $idtype;
            $like->id_user = $userid;
            if($like->save()) {
                if($type == 'bimbingan') {
                    Bimbingan::where('id',$idtype)->increment('is_liked');
                    
                } else if($type == 'tobk') {
                    TobkVideo::where('id', $idtype)->increment('is_liked');
                }
            }
            
            
        }
        
        if($type == 'bimbingan') {
            $d = Bimbingan::where('id', $idtype)->first();    
        } else if($type == 'tobk') {
            $d = TobkVideo::where('id', $idtype)->first();
        }
        
        
        return response()->json([
           "success" => true,
           "message" => 'sukses',
           "data" => $d->is_liked
            
        ]);
        
    }
    
    
    
    public function lihatBimbingan(Request $request) {
        $input = $request->all();
        $response = Bimbingan::where('id', $input['id'])->increment('is_watched');
        if($response) {
            $q = Bimbingan::findorFail($input['id']);
            $data = $q->is_watched;
            
            $suka = Like::where('id_type', $input['id'])
                    ->where('id_user', $input['id_user'])
                    ->where('type', 'bimbingan')
                    ->get();
                    
            if($suka->count() > 0) {
                $status_suka = true;
            }  else {
                $status_suka = false;
            }        
            return response()->json([
                "success" => true,
                "message"=>'sukses',
                "data" => $data,
                "liked" => $q->is_liked,
                "suka" => $status_suka
                ]);
        }
        
    }
    
    
    public function lihatTobk(Request $request) {
        $input = $request->all();
        $response = TobkVideo::where('id', $input['id'])->increment('is_watched');
        if($response) {
            $q = TobkVideo::findorFail($input['id']);
            $data = $q->is_watched;
            
            $suka = Like::where('id_type', $input['id'])
                    ->where('id_user', $input['id_user'])
                    ->where('type', 'tobk')
                    ->get();
                    
            if($suka->count() > 0) {
                $status_suka = true;
            }  else {
                $status_suka = false;
            }        
            return response()->json([
                "success" => true,
                "message"=>'sukses',
                "data" => $data,
                "liked" => $q->is_liked,
                "suka" => $status_suka
            ]);
        }
        
    }
    
    
    
    
    public function addComment(Request $request) {
        $input = $request->all();
        
        $comment = new Comment;
        $comment->id_user = $input['id_user'];
        $comment->type = $input['type'];
        $comment->id_comment = $input['id_comment'];
        $comment->isi_komentar = $input['isi'];
        $comment->is_publish = 1;
        $comment->save();
        
        return response()->json([
            'success'=> true,
            'message' => 'success'
            
            ]);
        
        
    }
    
    
    public function comment(Request $request) {
       $input = $request->all();
       
       $comment = DB::table('comments')
            ->select('comments.*', 'users.name', 'users.profile_image', DB::raw("date_format(comments.created_at, '%d-%m-%Y') as tanggal"))
            ->where('comments.type', $input['type'])
            ->where('comments.id_comment', $input['id_comment'])
            ->where('comments.is_publish', 1)
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->orderBy('comments.id', 'desc')
            ->limit(5)
            ->get();
            
            
        $commentall = DB::table('comments')
            ->select('comments.*', 'users.name', 'users.profile_image', DB::raw("date_format(comments.created_at, '%d-%m-%Y') as tanggal"))
            ->where('comments.type', $input['type'])
            ->where('comments.id_comment', $input['id_comment'])
            ->where('comments.is_publish', 1)
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->orderBy('comments.id', 'desc')
            ->get();
            
            
       return response()->json([
           'success' => true,
           'data' => $comment,
           'data_all' => $commentall,
           'jumlah' => $commentall->count()
           
           ]);
    }
    
    public function bimbingan(Request $request) {
        $input = $request->all();
        $bimbingan = Bimbingan::where('id_kategori', $input['id_kategori'])
                    ->where('is_active', 1)
                    ->get();
        $rows = [];            
        foreach($bimbingan as $b) {
            $kelas = explode(",", $b->id_kelas);
            $cek = array_search((string)$input['id_kelas'], $kelas, true);
            
            if($cek !== false) {
                $row['id'] = $b->id;
                $row['id_kategori'] = $b->id_kategori;
                $row['id_kelas'] = $b->id_kelas;
                $row['id_mapel'] = $b->id_mapel;
                $row['judul'] = $b->judul;
                $row['link_video'] = $b->link_video;
                $row['is_active'] = $b->is_active;
                $row['is_watched'] = $b->is_watched;
                $row['is_liked'] = $b->is_liked;
                $row['created_at'] = $b->created_at;
                $row['updated_at'] = $b->updated_at;
                array_push($rows, $row);
            }
            
        }
                    
        return response()->json([
            "success"=> true,
            "data" => $rows
            
        ]);
    }
    
    
    public function materiList(Request $request) {
        $input = $request->all();
        $materi = MateriPembelajaran::where('id_kategori', $input['id_kategori'])
                    ->where('is_active', 1)
                    ->get();
                    
        $rows = [];
        foreach($materi as $m) {
            $kelas = explode(",", $m->id_kelas);
            $cek = array_search((string)$input['id_kelas'], $kelas, true);
            
            if($cek !== false) {
                $row['id'] = $m->id;
                $row['id_kategori'] = $m->id_kategori;
                $row['id_kelas'] = $m->id_kelas;
                $row['id_mapel'] = $m->id_mapel;
                $row['judul'] = $m->judul;
                $row['link_file'] = $m->link_file;
                $row['is_active'] = $m->is_active;
                $row['is_watched'] = $m->is_watched;
                $row['is_liked'] = $m->is_liked;
                $row['created_at'] = $m->created_at;
                $row['updated_at'] = $m->updated_at;
                array_push($rows, $row); 
            }
            
            
        }
        return response()->json([
            "success"=> true,
            "data" => $rows
            
        ]);
    }
}
