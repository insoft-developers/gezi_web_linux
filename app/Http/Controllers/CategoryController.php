<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $input = $request->all();
        $rows = [];
        $kategori = Category::where('is_active', 1)
                    ->where('id_mapel',$input['id_mapel'] )
                    ->orderBy('urutan','asc')
                    ->get();
         
        foreach($kategori as $k) {
            $kelas = explode(",", $k->id_kelas);
            $ik = array_search((string)$input['id_kelas'], $kelas, true);
            if($ik !== false) {
                $row['id'] = $k->id;
                $row['id_mapel'] = $k->id_mapel;
                $row['category_name'] = $k->category_name;
                $row['is_active'] = $k->is_active;
                $row['created_at'] = $k->created_at;
                $row['updated_at'] = $k->updated_at;
                $row['category_image'] = $k->category_image;
                $row['id_kelas'] = $k->id_kelas;
                array_push($rows, $row);
            }
            
            
        }
                    
        return response()->json([
            "success" => true,
            "data" => $rows
            
            ]);
        
    }
}
