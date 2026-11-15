<?php

namespace App\Services;

use App\User;
use App\ParentAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class ParentActivationService
{
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

    public function activate(User $student, array $guardians)
    {
        return DB::transaction(function () use (
            $student,
            $guardians
        ) {

            if (!$student->school_id) {
                throw new Exception(
                    'Sekolah siswa belum ditentukan'
                );
            }

            $results = [];

            foreach ($guardians as $guardian) {

                $name = trim($guardian['name']);
                $phone = $this->normalizePhone(
                    $guardian['phone']
                );

                $relationship = $guardian['relationship'];

                if (!$name || !$phone) {
                    throw new Exception(
                        'Nama dan nomor HP wajib diisi'
                    );
                }

                if (!in_array(
                    $relationship,
                    ['ayah', 'ibu', 'wali']
                )) {
                    throw new Exception(
                        'Hubungan orang tua tidak valid'
                    );
                }

                // Cari akun berdasarkan sekolah dan HP
                $parent = ParentAccount::where(
                    'school_id',
                    $student->school_id
                )->where(
                    'phone',
                    $phone
                )->lockForUpdate()->first();

                $isNew = false;

                // Jika belum ada, buat akun baru
                if (!$parent) {

                    $parent = ParentAccount::create([
                        'name' => $name,
                        'phone' => $phone,
                        'password' => Hash::make('12345678'),
                        'school_id' => $student->school_id,
                        'is_active' => true,
                        'must_change_password' => true,
                    ]);

                    $isNew = true;
                }

                // Jika akun sudah ada, jangan reset password.
                // Cukup hubungkan dengan siswa.
                $existing = DB::table('parent_student')
                    ->where('parent_id', $parent->id)
                    ->where('student_id', $student->id)
                    ->first();

                if ($existing) {

                    if ($existing->relationship !== $relationship) {
                        throw new Exception(
                            'Akun nomor HP ' . $phone .
                                ' sudah terdaftar sebagai ' . $existing->relationship .
                                '. Silakan periksa data orang tua siswa.'
                        );
                    }
                } else {

                    DB::table('parent_student')->insert([
                        'parent_id' => $parent->id,
                        'student_id' => $student->id,
                        'relationship' => $relationship,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $results[] = [
                    'parent_id' => $parent->id,
                    'name' => $parent->name,
                    'phone' => $parent->phone,
                    'relationship' => $relationship,
                    'is_new' => $isNew,
                    'initial_password' => $isNew
                        ? '12345678'
                        : null,
                ];
            }

            return $results;
        });
    }
}
