<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $fillable = [
      "from",
      "destination",
      "title",
      "content",
      "page",
      "status"
        
    ];
}
