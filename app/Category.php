<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id_mapel', 'category_name', 'is_active', 'category_image', 'urutan'];
}
