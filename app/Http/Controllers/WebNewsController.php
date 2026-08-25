<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\News;
use Session;
class WebNewsController extends Controller
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
        $view = 'news';
        return view('home.news', compact('view'));
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
        $input['news_image'] = null;
        $unique = uniqid();
        if($request->hasFile('news_image')){
            $input['news_image'] = str_slug($unique, ' - ').'.'.$request->news_image->getClientOriginalExtension();
            $request->news_image->move(public_path('/images/berita'), $input['news_image']);
        }

        News::create($input);

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
        $news = News::findorFail($id);
        return $news;
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
        $news = News::findorFail($id);
        
        $input['news_image'] = $news->news_image;

        if($request->hasFile('news_image')){
            if($news->news_image != NULL){
                unlink(public_path('/images/berita/'.$news->news_image));
            }
            
            $unique = uniqid();
            $input['news_image'] = str_slug($unique, ' - ').'.'.$request->news_image->getClientOriginalExtension();
            $request->news_image->move(public_path('/images/berita'), $input['news_image']);
        }

        $news->update($input);
        
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
        $news=News::findorFail($id);
        if($news->news_image != NULL){
            unlink(public_path('/images/berita/'.$news->news_image));
        }

        News::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function newsTable()
    {
        $news = News::all();
        return Datatables::of($news)
           ->addColumn('is_active', function($news){
               if($news->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           ->addColumn('news_image', function($news){
               return '<img style="width:200px;height:120px;border-radius:10px;" src="'.asset('images/berita').'/'.$news->news_image.'" >';
           })
            ->addColumn('action', function($news){
                return '<center><a onclick="editData('. $news->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $news->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['is_active','news_image','action'])
        ->make(true);
    
    }
}
