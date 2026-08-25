<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['promo_title', 'promo_image', 'promo_content', 'is_active'];
}
