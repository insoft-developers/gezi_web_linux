<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref extends Model
{
    protected $fillable = [
      "ref_title",
      "ref_url",
      "ref_image"
    ];
}
