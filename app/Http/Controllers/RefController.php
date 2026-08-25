<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ref;
use Yajra\DataTables\Datatables;
use Session;
use App\Kelas;

class RefController extends Controller
{
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $view = 'ref';
        $kelas = Kelas::all();
        return view('home.ref', compact('view','kelas'));
    }
    
    public function store(Request $request)
    {
        
        try {
            $input = $request->all();
            $input['ref_image'] = null;
            $unique = uniqid();
            if($request->hasFile('ref_image')){
                $input['ref_image'] = str_slug($unique, '-').'.'.$request->ref_image->getClientOriginalExtension();
                $request->ref_image->move(public_path('/images/ref'), $input['ref_image']);
            }
            
            $kelas = implode(",", $input['id_kelas']);
    
            $ref = new Ref;
            $ref->ref_title = $input['ref_title'];
            $ref->ref_url = $input['ref_url'];
            $ref->ref_image = $input['ref_image'];
            $ref->id_kelas = $kelas;
            $ref->is_active = $input['is_active'];
            $ref->created_at = date('Y-m-d H:i:s');
            $ref->updated_at = date('Y-m-d H:i:s');
            $ref->save();
    
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage()
            ]);
        }
        
        
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
        $ref['data'] = Ref::findorFail($id);
        $ref['kelas'] = explode(",", $ref['data']->id_kelas);
        return response()->json($ref);
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
        
        try {
            $input = $request->all();
            $ref = Ref::findorFail($id);
            $input['ref_image'] = $ref->ref_image;
            
            $unique = uniqid();
            if($request->hasFile('ref_image')){
                if(file_exists(public_path("/images/ref/".$ref->ref_image.""))){
                    unlink(public_path("/images/ref/".$ref->ref_image.""));
                }
                $input['ref_image'] = str_slug($unique, '-').'.'.$request->ref_image->getClientOriginalExtension();
                $request->ref_image->move(public_path('/images/ref'), $input['ref_image']);
            }
            
            $kelas = implode(",", $input['id_kelas']);
    
            
            $ref->ref_title = $input['ref_title'];
            $ref->ref_url = $input['ref_url'];
            $ref->ref_image = $input['ref_image'];
            $ref->id_kelas = $kelas;
            $ref->is_active = $input['is_active'];
            $ref->updated_at = date('Y-m-d H:i:s');
            $ref->save();
    
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref = Ref::findorFail($id);
        if(file_exists(public_path("/images/ref/".$ref->ref_image.""))){
            unlink(public_path("/images/ref/".$ref->ref_image.""));
        }
        $ref->delete();
        return $ref;
    }
    
    
    
    public function refTable()
    {
        $ref = Ref::all();
        return Datatables::of($ref)
            ->addColumn('is_active', function($ref){
               if($ref->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
            })
            ->addColumn('id_kelas', function($ref){
                $kelas = explode(",", $ref->id_kelas);
                $html = "";
                $html .= "<ul>";
                foreach($kelas as $k) {
                    $nk = Kelas::findorFail($k);
                    $html .= "<li>".$nk->nama_kelas."</li>";
                }
                $html .= "</ul>";
                return $html;
            })
            ->addColumn('ref_image', function($ref){
                return '<img style="height:100px;width:80px;border-radius:10px;" src="'.asset('images/ref').'/'.$ref->ref_image.'">';
            })
            ->addColumn('action', function($ref){
                return '<center><a onclick="editData('. $ref->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $ref->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['action', 'ref_image', 'id_kelas','is_active'])
        ->make(true);
    
    }
}
