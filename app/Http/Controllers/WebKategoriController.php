<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Category;
use App\Kelas;
use App\Mapel;
use DB;
use Session;

class WebKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'kategori';
        $kelas = Kelas::all();
        $mapel = Mapel::all(); 
        return view('bimbel.kategori', compact('view', 'kelas', 'mapel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKelasByMapel($id)
    {
        $mapel = Mapel::findorFail($id);
        $kelasString = $mapel->id_kelas;
        $kelasArray = explode(",", $kelasString);
        
        $html = "";
        foreach($kelasArray as $k) 
        {
            $kls = Kelas::findorFail($k);
            $html .= '<option value="'.$k.'">'.$kls->nama_kelas.'</option>';    
        }
        
        return $html;
    }
    
    
    function kategoriKelas($id)
    {
        $kategori = Category::findorFail($id);
        $kelas = explode("," ,$kategori->id_kelas);
        $rows = [];
        foreach($kelas as $k)
        {
            $idkelas = (int)$k;
            array_push($rows, $idkelas);
        }
        
        return $rows;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['category_image'] = null;
        $unique = uniqid();
        if($request->hasFile('category_image')){
            $input['category_image'] = str_slug($unique, ' - ').'.'.$request->category_image->getClientOriginalExtension();
            $request->category_image->move(public_path('/images/kategori'), $input['category_image']);
        }

        $query = Category::create($input);
        $id = $query->id;
        
        $up = Category::findorFail($id);
        $up->id_kelas = implode(",", $input['id_kelas']);
        $up->save();
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Category::findorFail($id);
        $data['data'] = $kategori;
        $idMapel = $kategori->id_mapel;
        $mapel = Mapel::findorFail($idMapel);
        $kelasString = $mapel->id_kelas;
        $kelasArray = explode(",", $kelasString);
        $kategoriKelas = explode(",", $kategori->id_kelas);
        
        
        
        $html = "";
        foreach($kelasArray as $k)
        {
            $kelas = Kelas::findorFail($k);
            $html .= '<option value="'.$k.'">'.$kelas->nama_kelas.'</option>';
           
        }
        
        
        $data['kelas'] = $html;
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $kategori = Category::findorFail($id);
        
        $input['category_image'] = $kategori->category_image;

        if($request->hasFile('category_image')){
            if($kategori->category_image != NULL){
                unlink(public_path('/images/kategori/'.$kategori->category_image));
            }
            
            $unique = uniqid();
            $input['category_image'] = str_slug($unique, ' - ').'.'.$request->category_image->getClientOriginalExtension();
            $request->category_image->move(public_path('/images/kategori'), $input['category_image']);
        }

        $kategori->update($input);
        
        $k = Category::findorFail($id);
        $k->id_kelas = implode(",", $input['id_kelas']);
        $k->save();
        
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori=Category::findorFail($id);
        if($kategori->category_image != NULL){
            unlink(public_path('/images/kategori/'.$kategori->category_image));
        }

        Category::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function kategoriTable()
    {
        $category = DB::table('categories')
                    ->select('categories.*', 'kelas.nama_kelas', 'mapels.mapel_name')
                    ->join('kelas', 'kelas.id', '=', 'categories.id_kelas')
                    ->join('mapels', 'mapels.id', '=', 'categories.id_mapel')
                    ->get();
        return Datatables::of($category)
          
           ->addColumn('urutan', function($category) {
               return '<center><strong>'.$category->urutan.'</strong></center>';
           })
           ->addColumn('is_active', function($category){
               if($category->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           ->addColumn('category_image', function($category){
               return '<center><img style="width:80px;height:80px;border-radius:10px;border:1px solid whitesmoke;" src="'.asset('images/kategori').'/'.$category->category_image.'" ></center>';
           })
           
           ->addColumn('nama_kelas', function($category){
               $kelasString = $category->id_kelas;
               $kelasArray = explode(",", $kelasString);
               
               $html = "";
               $html .= "<ul>";
               for($i=0; $i < count($kelasArray); $i++) 
               {
                   $id = (int)$kelasArray[$i]; 
                   $kelas = Kelas::findorFail($id);
                   $html .= '<li>'.$kelas->nama_kelas.'</li>';
               }
               $html .= "</ul>";
               
               return '<div>'.$html.'</div>';
           })
            ->addColumn('action', function($category){
                return '<center><a onclick="editData('. $category->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $category->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['urutan','nama_kelas','is_active','category_image','action'])
        ->make(true);
    
    }
}
