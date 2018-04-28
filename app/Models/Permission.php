<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $with = ['users', 'posts'];

    protected $fillable = ['mode'];

    public function users(){
        return $this->belongsToMany(Models\User::class);
    }

    public function posts(){
        return $this->hasMany(Models\Post::class);
    }
}
