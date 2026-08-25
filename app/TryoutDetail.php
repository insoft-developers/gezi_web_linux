<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TryoutDetail extends Model
{
    protected $table = "tryout_details";
    protected $fillable = ['id_tryout', 'no_soal', 'soal', 'gambar_soal', 'jawaban_a', 'gambar_a', 'jawaban_b', 'gambar_b', 'jawaban_c', 'gambar_c', 'jawaban_d', 'gambar_d', 'jawaban_e', 'gambar_e', 'kunci_jawaban','score', 'is_active'];
}
