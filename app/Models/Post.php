<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    public $with = ['permissions', 'users', 'edits'];

    protected $fillable = ['name', 'content', 'user_id'];

    public function permissions(){
        return $this->belongsToMany(Models\Permission::class);
    }

    public function users(){
        return $this->belongsToMany(Models\User::class);
    }

    public function edits(){
        return $this->hasMany(Models\Edit::class);
    }

    public function type(){
        return $this->hasOne(Models\PostType::class);
    }
}
