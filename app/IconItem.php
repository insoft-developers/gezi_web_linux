<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IconItem extends Model
{
    protected $guarded = ['id'];
    
    
    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'tingkat_id', 'id');
    }
}
