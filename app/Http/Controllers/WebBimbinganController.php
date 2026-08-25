<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Category;
use App\Kelas;
use App\Mapel;
use DB;
use App\Bimbingan;
use Session;
class WebBimbinganController extends Controller
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
        $view = 'bimbingan';
        $kategori = DB::table('categories')
                    ->select('categories.*', 'mapels.mapel_name')
                    ->where('categories.is_active', 1)
                    ->join('mapels', 'mapels.id', '=', 'categories.id_mapel')
                    ->get();
        
        return view('bimbel.bimbingan', compact('view', 'kategori'));
    }
    
    
    public function setKategori(Request $request) 
    {
        $input = $request->all();
        return Category::where('id_kelas', $input['idKelas'])->where('id_mapel', $input['idMapel'])->get();
        
    }

    
    public function categoryBimbel($id)
    {
        $kategori = Category::findorFail($id);
        $mapel = Mapel::findorFail($kategori->id_mapel);
        $m="";
        $m.= '<option value="'.$mapel->id.'">'.$mapel->mapel_name.'</option>';
        
        $kelas = explode(",", $kategori->id_kelas);
        
        $kls = "";
        foreach($kelas as $k) {
            $kn = Kelas::findorFail($k);
            $kls .= '<option value="'.$k.'">'.$kn->nama_kelas.'</option>';
        }
        
        
        $data['mapel'] = $m;
        $data['kelas'] = $kls;
        return $data; 
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
        $query = Bimbingan::create($input);
        $id = $query->id;
        
        $bimbingan = Bimbingan::findorFail($id);
        $bimbingan->id_kelas = implode(",", $input['id_kelas']);
        $bimbingan->save();

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
        $bimbingan = Bimbingan::findorFail($id);
        $kategori = Category::findorFail($bimbingan->id_kategori);
        $kelas = explode(",", $kategori->id_kelas);
        
        $kls = "";
        foreach($kelas as $k) {
            $kn = Kelas::findorFail($k); 
            $kls .= '<option value="'.$k.'">'.$kn->nama_kelas.'</option>';
        }
        
        
        $data['data'] = $bimbingan;
        $data['mapel'] = Mapel::findorFail($bimbingan->id_mapel);
        $data['kelas'] = $kls;
        
        return $data;
    }
    
    public function kelasSelectBimbingan($id) 
    {
        $bimbingan = Bimbingan::findorFail($id);
        $kelas = explode(",", $bimbingan->id_kelas);
        return $kelas;
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
        $bimbingan = Bimbingan::findorFail($id);
        
        $bimbingan->update($input);
        
        $b = Bimbingan::findorFail($id);
        $b->id_kelas = implode(",", $input['id_kelas']);
        $b->save();
        
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
        $bimbingan=Bimbingan::findorFail($id);
        Bimbingan::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function bimbinganTable()
    {
        $bimbingan = DB::table('bimbingans')
                    ->select('bimbingans.*', 'kelas.nama_kelas', 'mapels.mapel_name', 'categories.category_name')
                    ->join('kelas', 'kelas.id', '=', 'bimbingans.id_kelas')
                    ->join('mapels', 'mapels.id', '=', 'bimbingans.id_mapel')
                    ->join('categories', 'categories.id', '=', 'bimbingans.id_kategori')
                    ->get();
        return Datatables::of($bimbingan)
           ->addColumn('link_video', function($bimbingan){
               return '<div><a href="'.$bimbingan->link_video.'" target="_blank">'.$bimbingan->link_video.'</a><div>';
           })
           ->addColumn('is_active', function($bimbingan){
               if($bimbingan->is_active == 1) {
                   return '<center><span class="label label-success">Active</span><a href=""><i style="margin-left:13px;" class="fa fa-eye"> '.$bimbingan->is_watched.'</i></a><a href=""><i style="margin-left:13px;" class="fa fa-thumbs-up"> '.$bimbingan->is_liked.'</i></a></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span><a href=""><i style="margin-left:13px;" class="fa fa-eye"> '.$bimbingan->is_watched.'</i></a><a href=""><i style="margin-left:13px;" class="fa fa-thumbs-up"> '.$bimbingan->is_liked.'</i></a></center>';
               }
           })
           ->addColumn('nama_kelas', function($bimbingan){
               $kelasString = $bimbingan->id_kelas;
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
           
            ->addColumn('action', function($bimbingan){
                return '<center><a onclick="editData('. $bimbingan->id.')" style="margin-bottom:5px;width:30px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $bimbingan->id.')" style="width:30px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->addColumn('action2', function($bimbingan){
                return '<center><a onclick="editData('. $bimbingan->id.')" style="margin-bottom:5px;width:30px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $bimbingan->id.')" style="width:30px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['nama_kelas','link_video','is_active','action','action2'])
            ->make(true);
    
    }
}
