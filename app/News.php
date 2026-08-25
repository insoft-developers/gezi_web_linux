<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news'; 
    protected $fillable = ['news_title', 'news_content', 'news_image', 'is_active', 'user_id'];
}
