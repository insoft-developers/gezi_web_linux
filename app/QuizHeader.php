<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizHeader extends Model
{
    protected $fillable = [
        "judul",
        "waktu_kuis",
        "target_score",
        "is_active",
        "warna_soal",
        "warna_tulisan_soal",
        "warna_jawaban",
        "warna_tulisan_jawaban",
        "short_name",
        "urutan"
    ];
}
