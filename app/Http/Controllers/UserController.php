<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Kelas;
use App\School;
use App\Tingkat;
use App\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Mail\GenziEmail;
use Illuminate\Support\Facades\Mail;
use App\DashboardMenuSetting;

use Auth;

class UserController extends Controller
{
    public function dms()
    {
        $data = DashboardMenuSetting::all();
        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }


    public function userDetail(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $siswa = User::find($request->input('id'));

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }

        $kelas = Kelas::find($siswa->id_kelas);

        if ($kelas) {
            $siswa->kelas = $kelas->nama_kelas;

            $tingkat = Tingkat::find($kelas->tingkat_id);
            $siswa->tingkat = $tingkat ? $tingkat->name : '';
        } else {
            $siswa->kelas = '';
            $siswa->tingkat = '';
        }

        $location = Location::find($siswa->location_id);
        $siswa->location = $location ? $location->name : '';

        $siswa->created = $siswa->created_at
            ? $siswa->created_at->translatedFormat('d F Y')
            : '';

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $siswa
        ]);
    }

    public function pilihKelas(Request $request)
    {
        $input = $request->all();

        $query = Kelas::query();

        if (! empty($input['search'])) {
            $query->where('nama_kelas', 'LIKE', '%' . $input['search'] . '%');
        }
        $data = $query->get();

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    public function pilihSekolah(Request $request)
    {
        $input = $request->all();


        $query = School::orderBy('school_name', 'asc');
        if (! empty($input['search'])) {
            $query->where('school_name', 'LIKE', '%' . $input['search'] . '%');
        }
        $data = $query->get();

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }


    public function pilihLokasi(Request $request)
    {
        $input = $request->all();


        $query = Location::orderBy('name', 'asc');
        if (! empty($input['search'])) {
            $query->where('name', 'LIKE', '%' . $input['search'] . '%');
        }
        $data = $query->get();

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }



    public function changePassword(Request $request)
    {
        $input = $request->all();
        $user = User::where('email', $input['email'])->first();
        $hashedPassword = $user->password;
        if (Hash::check($input['old_password'], $hashedPassword)) {
            $us = User::where('email', $input['email'])->update(['password' => bcrypt($input['new_password'])]);
            if ($us) {
                return response([
                    "success" => true,
                    "message" => 'success'
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => 'failed'
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "message" => 'failed'
            ]);
        }
    }

    public function upload(Request $request)
    {
        $dir = 'images/profil/';
        $image = $request->file('image');
        $ids = $request->ids;


        if ($request->has('image')) {
            $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . "png";
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
        } else {
            return response()->json(['message' => trans('/storage/test/' . 'def.png.')], 200);
        }

        $user = User::findorFail($ids);
        $user->profile_image = $imageName;
        $user->save();
        return response()->json(['message' => trans('/storage/test/' . $imageName)], 200);
    }



    public function update(Request $request)
    {
        $input = $request->all();
        $user = User::findorFail($input['id']);
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        $user->save();
        if ($user) {
            return response()->json([
                "success" => true,
                "data" => $user->id
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => ''
            ]);
        }
    }


    public function getProfil(Request $request)
    {
        $input = $request->all();

        $user = User::findorFail($input['id']);


        return response()->json([
            "success" => true,
            "data" => $user,
            "relation" => $user->kelas
        ]);
    }


    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;




            $user = User::where('email', request('email'))->first();
            if ($user->is_login == 1 && $user->id !== 6600) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf Akun anda Sedang Digunakan'
                ]);
            }

            if ($user->is_active != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf Akun anda Belum Aktif'
                ]);
            }

            $user->is_login = 1;
            $user->last_login_date = date('Y-m-d H:i:s');
            $user->save();

            return response()->json([
                'success' => true,
                'token' => $success,
                'user' => $user,
                'message' => 'Login Berhasil'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
    }



    public function logout($id)
    {

        try {
            $user = User::findorFail($id);
            $user->is_login = 0;
            $user->last_login_date = date('Y-m-d H:i:s');
            $user->save();

            return response()->json([
                "success" => true,
                "message" => "logout success"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => true,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function registerUser(Request $request)
    {
        $input = $request->all();
        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->id_kelas = $input['class_id'];
        $user->class_group = $input['class_group'];
        $user->fathers_phone = $input['fathers_phone'];
        $user->mothers_phone = $input['mothers_phone'];
        $user->school_id = $input['school_id'];
        $user->phone = $input['phone'];
        $user->is_active = 0;
        $user->is_online = 0;
        $user->reg_id = "";
        $user->location_id = $input['location_id'];
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        return response()->json([
            "success" => true,
            "id_register" => $user->id
        ]);
    }


    public function sendEmail(Request $request)
    {

        $input = $request->all();
        $users = User::where('email', $input['email']);

        if ($users->count() > 0) {
            $user = $users->first();
            $unik = uniqid();
            $password = bcrypt($unik);
            User::where('email', $input['email'])->update(['password' => $password]);

            Mail::to($input['email'])->send(new GenziEmail($user, $unik));
            return response()->json([
                "success" => true,
                "message" => "Password Baru Anda Telah Terkirim ke Email Anda..!"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Email Tidak Terdaftar ..!"
            ]);
        }
    }
}
