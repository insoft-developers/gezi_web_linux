<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Notif;
use App\Admin;
use Session;
class WebNotifController extends Controller
{
   
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'pengumuman';
        return view('notif.index', compact('view'));
    }


    public function store(Request $request)
    {
        $input = $request->all();
        
        $query = Notif::create($input);
        if($query) {
            $this->notify($input['title'], $input['content']);
        }

        return response()->json([
            'success'=>true
        ]);
    }

  
    public function destroy($id)
    {
        
        Notif::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function notifTable()
    {
        $notif = Notif::where('title', '!=', 'Tanggapan Lapor Soal')->get();
        return Datatables::of($notif)
            ->addColumn('admin', function($notif){
                $admin = Admin::findorFail($notif->from);
                return '<div>'.$admin->name.'</div>';
            })
            ->addColumn('content', function($notif){
                $html ="";
                $html .= '<h4>'.$notif->title.'</h4>';
                $html .= '<p>'.$notif->content.'</p>';
                return '<div>'.$html.'</div>';
            })
            ->addColumn('action', function($notif){
                return '<a onclick="deleteData('. $notif->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['content','admin','action'])
        ->make(true);
    
    }
    
    
    public function notify($title, $message) {
        
        $SERVER_API_KEY = 'AAAAybILBXo:APA91bG14_pHYzcNT705unM-X5n-e3tV7kkHcSHM5R7pk8zHgGHxinKnHoXAaK_711vT2ni9G1l1hQqL4NGgizb_2CqYniqrGmzAwe-w87b88sCliJebZ_p9csK6Ir4ceQn2exhlfZRY';
        $data = [
    
            "to" => '/topics/zenius',
            "notification" => [
    
                "title" => $title,
    
                "body" => $message,
    
                "sound"=> "default" // required for sound on ios
    
            ],
    
        ];
    
        $dataString = json_encode($data);
    
        $headers = [
    
            'Authorization: key=' . $SERVER_API_KEY,
    
            'Content-Type: application/json',
    
        ];
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    
        curl_setopt($ch, CURLOPT_POST, true);
    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    
        $response = curl_exec($ch);
    
        
    }
}
