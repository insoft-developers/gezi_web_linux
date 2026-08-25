<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Question;
use App\Qanswer;
use App\User;
use App\Kelas;
use App\Admin;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function delete(Request $request) {
        $dir = public_path('storage/images/question/');
        $input = $request->all();
        $check = Question::findorFail($input['id']);
        $gambar = $check->gambar_soal;
        $file = $dir.$gambar;
        
        $query = Question::destroy($input['id']);
        if($query) {
            if(file_exists($file) && ! empty($gambar)) {
                unlink($file);
            }
            
            $message = [
                "success" => true,
                "message" => 'success'
            ];
        } else {
            $message = [
                "success" => false,
                "message" => 'failed'
            ];
        }
        
        return response()->json($message);
    }
    
    
    public function update(Request $request) {
        $input = $request->all();
        $question = Question::findorFail($input['id_question']);
        $question->id_user = $input['id_user'];
        $question->id_kelas = $input['id_kelas'];
        $question->soal = $input['soal'];
        $question->status = 1;
        $query = $question->save();
        
        
        if($query) {
            $message = [
                "success" => true,
                "data" => []
            ];
        } else {
            $message = [
                "success" => false,
                "data" => []
            ];
        }
        
        return response()->json($message);
    }
    
    
    public function add(Request $request) {
        $input = $request->all();
        $question = new Question;
        $question->id_user = $input['id_user'];
        $question->id_kelas = $input['id_kelas'];
        $question->soal = $input['soal'];
        $question->status = 1;
        $query = $question->save();
        
        
        if($query) {
            $message = [
                "success" => true,
                "data" => $question->id
            ];
        } else {
            $message = [
                "success" => false,
                "data" => []
            ];
        }
        
        return response()->json($message);
    }
    
    public function answer(Request $request) {
        $input = $request->all();
        $rows = [];
        $query = Qanswer::where('id_soal', $input['id_soal']);
        foreach($query->get() as $key) {
            $admin = Admin::findorFail($key->id_guru);
            
            $row['id'] = $key->id;
            $row['id_guru'] = $key->id_guru;
            $row['id_soal'] = $key->id_soal;
            $row['jawaban'] = $key->jawaban;
            $row['jawaban_gambar'] = $key->jawaban_gambar;
            $row['status'] = $key->status;
            $row['created_at'] = date('d-m-Y', strtotime($key->created_at));
            $row['timed_at'] = date('H:i:s', strtotime($key->created_at));
            $row['nama_guru'] = $admin->name;
            
            array_push($rows, $row);
        }
        
        if($query) {
            $message = [
                "success" => true,
                "data" => $rows
            ];
        } else {
            $message = [
                "success" => false,
                "data" => []
            ];
        }
        
        return response()->json($message);
        
    }
    
    
    public function list(Request $request) {
        $input = $request->all();
        $data = [];
        $query = Question::where('id_kelas', $input['id_kelas'])
            ->where('status', 1)
            ->orderBy('id', 'desc');
        if(! empty($input['cari'])) {
            $query->where('soal', 'like', '%' . $input['cari'] . '%');
        }
        
        foreach($query->get() as $key) {
            
            $kelas = Kelas::findorFail($key->id_kelas);
            $user = User::findorFail($key->id_user);
            
            $ans = Qanswer::where('id_soal', $key->id);
            
            $row['id'] = $key->id;
            $row['id_user'] = $key->id_user;
            $row['id_kelas'] = $key->id_kelas;
            $row['soal'] = $key->soal;
            $row['gambar_soal'] = $key->gambar_soal;
            $row['status'] = $key->status;
            $row['is_answered'] = $key->is_answered;
            $row['name'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['created_at'] = date('d-m-Y H:i:s', strtotime($key->created_at));
            $row['jawaban'] = $ans->count();
            array_push($data, $row);
        }
        
        if($query) {
            $message = [
                "success" => true,
                "data" => $data
            ];
        } else {
            $message = [
                "success" => false,
                "data" => []
            ];
        }
        
        return response()->json($message);
    }
    
    public function upload(Request $request) {
        $dir = 'images/question/';
        $image = $request->file('image');
        $ids = $request->ids;
        
        
        if($request->has('image')) {
            $imageName = \Carbon\Carbon::now()->toDateString()."-".uniqid()."."."png";
            Storage::disk('public')->put($dir.$imageName, file_get_contents($image));

        } else {
            return response()->json(['message'=> trans('/storage/test/'.'def.png.')],200);
        }
        
        $question = Question::findorFail($ids);
        $question->gambar_soal = $imageName;
        $question->save();
        return response()->json(['message'=> trans('/storage/test/'.$imageName)],200);
        
        
    }
}
