<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use Yajra\DataTables\Datatables;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class SubjectController extends Controller
{
    public function table()
    {
        $mapel = Subject::all();
        return Datatables::of($mapel)
           ->addColumn('urutan', function($mapel) {
               return '<center><strong>'.$mapel->urutan.'</strong></center>';
           })
           ->addColumn('image', function($mapel){
               return '<img style="width:100px;height:100px;border-radius:10px;" src="'.asset('/storage/images/subject').'/'.$mapel->image.'" >';
           })
           ->addColumn('is_active', function($mapel){
               if($mapel->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           
           ->addColumn('created_at', function($mapel){
               if(! empty($mapel->created_at)) {
                    return '<center>'.date('d-m-Y', strtotime($mapel->created_at)).'</center>';    
               } else {
                    return '';
               }
               
           })
           
            ->addColumn('action', function($mapel){
                return '<center><a onclick="editData('. $mapel->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $mapel->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['urutan','created_at','is_active','image','action'])
        ->make(true);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'subject';
        return view('tryout.subject', compact('view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
        $input['image'] = null;
        $unique = uniqid();
        
        
        if ($request->hasFile('image')) {

            $filename = Str::slug($unique, '-') . '.' . $request->file('image')->getClientOriginalExtension();
        
            $image = Image::make($request->file('image'))
            ->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        
            Storage::disk('public')->put(
                'images/subject/' . $filename,
                (string) $image->encode()
            );
        
            $input['image'] = $filename;
        }

        Subject::create($input);
        
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
        $data = Subject::find($id);
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
        $subject = Subject::findOrFail($id);

        $input = $request->all();
    
        if ($request->hasFile('image')) {
    
            // Hapus gambar lama
            if (!empty($subject->image)) {
                $oldImage = 'images/subject/' . $subject->image;
    
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
    
            // Nama file baru
            $filename = Str::slug(uniqid(), '-') . '.' . $request->file('image')->getClientOriginalExtension();
    
            // Resize gambar
            $image = Image::make($request->file('image'))
                ->resize(600, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
    
            // Simpan ke storage
            Storage::disk('public')->put(
                'images/subject/' . $filename,
                (string) $image->encode()
            );
    
            // Simpan nama file ke database
            $input['image'] = $filename;
        } else {
            // Jika tidak upload gambar baru, gunakan gambar lama
            $input['image'] = $subject->image;
        }
        
        $oldUrutan = $subject->urutan;
        $newUrutan = $request->urutan;
        
        if ($oldUrutan != $newUrutan) {
        
            // Cari data yang memiliki urutan tujuan
            $target = Subject::where('urutan', $newUrutan)->first();
        
            if ($target) {
                $target->urutan = $oldUrutan;
                $target->save();
            }
        }
    
        $subject->update($input);
    
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.'
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
        $subject = Subject::findOrFail($id);

        // Hapus gambar jika ada
        if (!empty($subject->image)) {
    
            $path = 'images/subject/' . $subject->image;
    
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    
        // Hapus data dari database
        $subject->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
    
    public function generateUrutan()
    {
        $urutan = Subject::max('urutan');

        $hasil = is_null($urutan) ? 1 : $urutan + 1;
        return response()->json($hasil);
    }
}
