<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'informations';
    protected $fillable = ['information_title', 'information_content', 'information_image', 'is_active'];
}
