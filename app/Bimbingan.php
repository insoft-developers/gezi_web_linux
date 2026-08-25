<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $fillable = ['id_kategori', 'id_mapel', 'judul', 'link_video', 'is_active']; 
}
