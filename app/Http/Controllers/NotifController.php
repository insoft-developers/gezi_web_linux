<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notif;
use App\User;
use App\Chat;
use DB;
class NotifController extends Controller
{
    
    public function chatRoom(Request $request) {
        $input = $request->all();
        $dari = $input['from'];
        $untuk = $input['destination'];
        $type = $input['type'];
        
        $results = DB::table('chats')
         ->where(function($query) use ($dari, $untuk){
             $query->where('from', $dari);
             $query->where('destination',$untuk);
         })
         ->orWhere(function($query) use ($dari, $untuk){
             $query->where('from', $untuk);
             $query->where('destination', $dari);
         })
         ->orderBy('id','desc')
         ->get();
        
        if($results) {
            if($type == 1) {
                Chat::where('from', $input['from'])->where('destination', $input['destination'])->update(["status"=> 1]);
                
            }
            return response()->json([
                "success" => true,
                "data" => $results,
            ]);    
        }
        
        
    }
    
    public function userChat(Request $request) {
        $input = $request->all();
        
        $cari = $input['cari'];
        
       
        $user = DB::table('users')
                ->select('users.*', 'kelas.nama_kelas')
                ->join('kelas', 'kelas.id', '=', 'users.id_kelas')
                ->where('users.id','!=', $input['id']);
                
        if(! empty($cari)) {
            $user->where('name', 'like', '%' . $cari . '%');    
        }
                
        
        $list = $user->get();
        
        $rows = [];
        foreach($list as $key) {
            
            $count = Chat::where('from', $key->id)->where('status', 0)->count();
            $last = Chat::where('from', $key->id)->where('destination', $input['id'])->orderBy('id', 'desc')->first();
            if(!empty($last)) {
                $lst = date('d-m-Y', strtotime($last->created_at));
                $time = date('H:i:s', strtotime($last->created_at));
            } else {
                $lst = 'No Chat';
                $time = "";
            }
            
            $row['id'] = $key->id;
            $row['name'] = $key->name;
            $row['email'] = $key->email;
            $row['created_at'] = $key->created_at;
            $row['updated_at'] = $key->updated_at;
            $row['id_kelas'] = $key->id_kelas;
            $row['profile_image'] = $key->profile_image;
            $row['phone'] = $key->phone;
            $row['reg_id'] = $key->reg_id;
            $row['is_online'] = $key->is_online;
            $row['nama_kelas'] = $key->nama_kelas;
            $row['count'] = $count;
            $row['last'] = $lst;
            $row['time'] = $time;
            array_push($rows, $row);
        }
                
        return response()->json([
            "success" => true,
            "data" => $rows
        ]);
    }
    
    
    public function chat(Request $request) {
        $input = $request->all();
        $message = $input['content'];
        $to = $input['destination'];
        
        $user = User::findorFail($to);
        $regid = $user->reg_id;
        
        
        $chat = new Chat;
        $chat->from = $input['from'];
        $chat->destination = $input['destination'];
        $chat->picture = '';
        $chat->content = $input['content'];
        $chat->status = 0;
        $chat->created_at = date('Y-m-d H:i:s');
        $chat->updated_at = date('Y-m-d H:i:s');
        $query = $chat->save();
        
        $SERVER_API_KEY = 'AAAAybILBXo:APA91bG14_pHYzcNT705unM-X5n-e3tV7kkHcSHM5R7pk8zHgGHxinKnHoXAaK_711vT2ni9G1l1hQqL4NGgizb_2CqYniqrGmzAwe-w87b88sCliJebZ_p9csK6Ir4ceQn2exhlfZRY';
        $data = [
    
            "to" => $regid,
            "notification" => [
                "body" => $message,
                "title" => $input['from'],
                "type" => "chat",
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
    
        if($query) {
            return response()->json([
               "success" => true,
               "message" => 'success'
            ]);
        }
    }
    
    
    public function fcmToken(Request $request) {
        $input = $request->all();
        $user = User::findorFail($input['id']);
        $user->reg_id = $input['fcm_token'];
        $query = $user->save();
        if($query) {
            return response()->json([
                "success" => true,
                "message" => "success"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "failed"
            ]);
        }
        
    }
    
    public function read(Request $request) {
        $input = $request->all();
        $id = $input['id'];
        $notif = Notif::findorFail($id);
        $notif->status = 0;
        $query = $notif->save();
        if($query) {
            return response()->json([
               "success" => true,
               "message" => 'success'
            ]);
        }
        
    }
    
    public function count(Request $request) {
        $input = $request->all();
        $notif = Notif::where('destination', 0)->orWhere('destination', $input['user_id'])->orderBy('id', 'desc');
        
        
        $rows = [];
        $belumDibaca = 0;
        foreach($notif->get() as $key) {
            if($key->status == 1 ) {
                $belumDibaca++;
            }
            
            $row['id'] = $key->id;
            $row['from'] = $key->from;
            $row['destination'] = $key->destination;
            $row['title'] = $key->title;
            $row['content'] = $key->content;
            $row['page'] = $key->page;
            $row['status'] = $key->status;
            $row['tanggal'] = date('d-m-Y', strtotime($key->created_at));
            $row['jam'] = date('H:i:s', strtotime($key->created_at));
            array_push($rows, $row);
        }
        
        
        return response()->json([
           "success" => true,
           "data" => $rows,
           "count" => $belumDibaca
        ]);
    }
    
    
    public function send(Request $request) {
        $input = $request->all();
        $notif = new Notif;
        $notif->from = $input['from'];
        $notif->destination = $input['destination'];
        $notif->title = $input['title'];
        $notif->content = $input['content'];
        $notif->page = "page";
        $notif->status = 1;
        $query = $notif->save();
        
        if($query) {
            $this->notify($input['title'], $input['content']);
        }
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
    
        dd($response);
    }
    

}
