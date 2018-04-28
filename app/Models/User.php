<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $with = ['groups', 'permissions', 'posts', 'edits', 'files'];

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function groups(){
        return $this->belongsToMany(Models\Group::class);
    }

    public function permissions(){
        return $this->hasMany(Models\Permission::class);
    }

    public function posts(){
        return $this->hasMany(Models\Post::class);
    }

    public function edits(){
        return $this->belongsTo(Models\Edit::class);
    }

    public function files(){
        return $this->hasMany(Models\File::class);
    }
}
