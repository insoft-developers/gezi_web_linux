<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TryoutReport;
use Yajra\DataTables\Datatables;
use App\TryoutDetail;
use App\BankSoalDetail;
use App\TryOut;
use App\BankSoal;

use App\Notif;
use Session;
class LaporController extends Controller
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
        $view = 'lapor';
        return view('question.lapor', compact('view'));
    }

    public function laporFinish(Request $request)
    {
        $input = $request->all();
        
        $tr = TryoutReport::findorFail($input['id']);
        $tr->status = 1;
        $tr->finish_date = date('Y-m-d H:i:s');
        $tr->id_user_finish = Session::get('id');
        $query = $tr->save();
        
        if($query)
        {
            if($tr->kategori == 'tryout') {
                $judul = "TRY OUT";
                $data = TryoutDetail::findorFail($tr->id_soal);
                $header = TryOut::findorFail($data->id_tryout);
            } else {
                $judul = "BANK SOAL";
                $data = BankSoalDetail::findorFail($tr->id_soal);
                $header = BankSoal::findorFail($data->id_bank_soal);
                
            }
            
            $content = "Laporan Untuk ".$judul." Dengan Judul ".$header->judul." No Soal: ".$data->no_soal." Sudah Ditanggapi";
            
            $this->send(Session::get('id'), 0, "Tanggapan Lapor Soal", $content);    
        }
         
        return response()->json([
           "success" => true 
        ]);
        
    }
    
    
    public function laporOutstanding(Request $request)
    {
        $input = $request->all();
        
        $tr = TryoutReport::findorFail($input['id']);
        $tr->status = 0;
        $tr->outstanding_date = date('Y-m-d H:i:s');
        $tr->id_user_outstanding = Session::get('id');
        $tr->save();
        
        return response()->json([
           "success" => true 
        ]);
    }
    
    
    public function laporTable()
    {
        $lapor = TryoutReport::all();
        return Datatables::of($lapor)
            ->addColumn('nama', function($lapor){
                $user = \App\User::findorFail($lapor->id_user);
                return '<div>'.$user->name.'</div>';
            })
            
            ->addColumn('kelas', function($lapor){
                $user = \App\User::findorFail($lapor->id_user);
                $kelas = \App\Kelas::findorFail($user->id_kelas);
                return '<div>'.$kelas->nama_kelas.'</div>';
            })
            
            ->addColumn('soal' ,function($lapor){
                if($lapor->kategori == 'tryout') {
                    $data = TryoutDetail::findorFail($lapor->id_soal);
                    $header = TryOut::findorFail($data->id_tryout);
                } else {
                    $data = BankSoalDetail::findorFail($lapor->id_soal);
                    $header = BankSoal::findorFail($data->id_bank_soal);
                }
                
                $html = "";
                $html .= '<span>'.$header->judul.'</span>';
                $html .= '<br>No Soal : '.$data->no_soal;
                $html .= '<br>Soal : '.$data->soal;
                $html .= '<br><strong>Laporan : '.$lapor->isi_laporan.'</strong>';
                return '<div>'.$html.'</div>';
            })
            ->addColumn('jenis', function($lapor){
                if($lapor->kategori == 'tryout') {
                    return '<div>TRY OUT</div>';    
                } else {
                    return '<div>BANK SOAL</div>';
                }
                
            })
            
            ->addColumn('status', function($lapor){
               if($lapor->status == 1) {
                   return '<center><span class="label label-success">Finished</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Outstanding</span></center>';
               }
           })
           ->addColumn('created_at', function($lapor){
               return '<div>'.date('d-m-Y', strtotime($lapor->created_at)).'</div>';
           })
            ->addColumn('action', function($lapor){
                if($lapor->status == 1) {
                    return '<center><a style="margin-bottom:5px;width:90px;" disabled class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Finished</a>'.
                '<br><a onclick="outstandData('. $lapor->id.')" style="width:90px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Outstanding</a></center>';    
                } else {
                   return '<center><a onclick="finishData('. $lapor->id.')" style="margin-bottom:5px;width:90px;" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Finished</a>'.
                '<br><a style="width:90px;" disabled class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Outstanding</a></center>';
                }
               
        })->rawColumns(['action','nama','kelas','soal','jenis','status','created_at'])
        ->make(true);
    
    }
    
    
    public function send($from, $destination, $title, $content) {
        
        $notif = new Notif;
        $notif->from = $from;
        $notif->destination = $destination;
        $notif->title = $title;
        $notif->content = $content;
        $notif->page = "page";
        $notif->status = 1;
        $query = $notif->save();
        
        if($query) {
            $this->notify($title, $content);
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
    
        
    }
    
}
