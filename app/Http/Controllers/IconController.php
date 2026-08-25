<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\MainMenu;
use App\Tingkat;
use App\IconItem;
use Session;
use Illuminate\Support\Facades\DB;


class IconController extends Controller
{
    
    public function simpanItem(Request $request)
    {
        $menuId = $request->menu_id;
        $items = $request->items;
    
        foreach ($items as $item) {
            IconItem::create([
                'icon_id' => $menuId,
                'link' => $item['link'],
                'tingkat_id' => $item['tingkat_id']
            ]);
        }
    
        return response()->json(['message' => 'Berhasil disimpan']);
    }
    
   


    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'main-menu';
        $tingkats = Tingkat::all();
        return view('home.menu', compact('view','tingkats'));
    }

   
    public function edit($id)
    {
        $menu = MainMenu::findorFail($id);
        return $menu;
    }

    
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $menu = MainMenu::findorFail($id);
        
        $input['icon_image'] = $menu->icon_image;

        if($request->hasFile('icon_image')){
            if($menu->icon_image != NULL && file_exists(public_path('/images/iconmenu/'.$menu->icon_image))){
                unlink(public_path('/images/iconmenu/'.$menu->icon_image));
            }
            
            $unique = uniqid();
            $input['icon_image'] = str_slug($unique, ' - ').'.'.$request->icon_image->getClientOriginalExtension();
            $request->icon_image->move(public_path('/images/iconmenu'), $input['icon_image']);
        }

        $menu->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }

    public function deleteItem($id)
    {
        DB::table('icon_items')->where('id', $id)->delete();
    
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    
    
    public function iconTable()
    {
        $menu = MainMenu::all();
        return Datatables::of($menu)
        
           ->addColumn('name', function($menu){
               $html = '';
               $html .= $menu->name;
               if($menu->id == 7 || $menu->id == 8) {
                    $items = \App\IconItem::where('icon_id', $menu->id)->get();
                   $html .= '<table id="table-items-'.$menu->id.'" style="margin-top:10px;" class="table table-bordered table-stripped">';
                    $html .= '<thead><tr>';
                    $html .= '<th>No</th>';
                    $html .= '<th>Link</th>';
                    $html .= '<th>Tingkat</th>';
                    $html .= '<th>Action <i onclick="add_row('.$menu->id.')" class="fa fa-plus btn btn-success pull-right"></i></th>';
                    $html .= '</tr></thead>';
                    $html .= '<tbody>';
                    
                    foreach($items as $index => $item) {
                        $html .= '<tr id="row_'.$item->id.'">';
                        $html .= '<td>'.($index + 1).'</td>';
                        $html .= '<td>'.$item->link.'</td>';
                        $html .= '<td>'.$item->tingkat->name.'</td>';
                        $html .= '<td>
                            <i class="fa fa-remove btn btn-danger" onclick="delete_row('.$item->id.', this, \'#table-items-'.$menu->id.'\')"></i>
                          </td>';
                        $html .= '</tr>';
                    }
                    
                    $html .= '</tbody></table>';
                    $html .= '<button onclick="save_items('.$menu->id.')" class="btn btn-primary" style="margin-top: 10px;">Simpan</button>';

               }
               
               return $html;
           })
           
           ->addColumn('icon_image', function($menu){
               if(! empty($menu->icon_image) && file_exists(public_path('/images/iconmenu/'.$menu->icon_image))) {
                   return '<img style="width:90px;height:90px;border-radius:45px;" src="'.asset('images/iconmenu').'/'.$menu->icon_image.'" >';
               } else{
                   return 'No Image';
               }
               
           })
            ->addColumn('action', function($menu){
                return '<center><a onclick="editData('. $menu->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a></center>';
        })->rawColumns(['icon_image','action','name'])
        ->make(true);
    
    }
}
