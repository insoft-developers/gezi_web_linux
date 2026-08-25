<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    protected $table = 'materi_pelajaran'; 
    protected $fillable = ['id_kategori', 'id_mapel', 'judul', 'link_file', 'is_active'];
}
