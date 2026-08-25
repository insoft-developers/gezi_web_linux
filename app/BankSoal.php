<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    protected $fillable = [
      "judul",
      "short_name",
      "id_kategori",
      "is_active",
      "is_skipped",
      "is_repeated",
      "target_score",
      "warna_soal",
      "warna_tulisan",
      "warna_jawaban",
      "warna_tulisan_jawaban",
      "urutan"
    ];    
}
