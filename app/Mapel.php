<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = ['mapel_name', 'mapel_image', 'is_active', 'created_at','urutan'];
}
