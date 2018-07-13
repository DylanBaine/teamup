<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public function pages(){
        return $this->hasMany(Post::class);
    }

    public function homePage(){
        return $this->belongsTo(Post::class, 'home_page_post_id');
    }
}
