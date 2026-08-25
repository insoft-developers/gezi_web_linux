<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    
    
    public function quizes() {
        return $this->hasMany('App\Quizes', 'id');
    }
}
