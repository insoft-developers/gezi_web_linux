<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $fillable = [
        "name",
        "icon_image"
        
    ];
    
    
    public function icon_items()
    {
        return $this->hasMany(IconItem::class, 'icon_id', 'id');
    }
}
