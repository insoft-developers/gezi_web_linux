<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParentAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    /**
     * Login orang tua
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $phone = $this->normalizePhone($request->phone);

        $parent = ParentAccount::where(
            'phone',
            $phone
        )->first();

        if (!$parent || !Hash::check(
            $request->password,
            $parent->password
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor HP atau password salah',
            ], 401);
        }

        if (!$parent->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun orang tua belum aktif',
            ], 403);
        }

        $token = $parent->createToken(
            'parentApp'
        )->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'must_change_password' =>
            (bool) $parent->must_change_password,
            'parent' => [
                'id' => $parent->id,
                'name' => $parent->name,
                'phone' => $parent->phone,
                'school_id' => $parent->school_id,
            ],
        ]);
    }

    /**
     * Daftar anak yang terhubung
     */
    public function children(Request $request)
    {
        $parent = $request->user('parent-api');

        $children = $parent->children()
            ->select([
                'users.id',
                'users.name',
                'users.id_kelas',
                'users.profile_image',
                'users.phone',
                'users.nis',
                'users.school_id',
                'users.class_group',
            ])
            ->with('kelas')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $children,
        ]);
    }

    /**
     * Mengganti password pertama kali
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $parent = $request->user('parent-api');

        if (!Hash::check(
            $request->old_password,
            $parent->password
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai',
            ], 400);
        }

        $parent->password = Hash::make(
            $request->new_password
        );

        $parent->must_change_password = false;

        $parent->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui',
        ]);
    }

    /**
     * Logout orang tua
     */
    public function logout(Request $request)
    {
        $parent = $request->user('parent-api');

        if ($parent && $parent->token()) {
            $parent->token()->revoke();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Normalisasi nomor HP Indonesia
     */
    private function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
