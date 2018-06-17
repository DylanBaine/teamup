<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name', 'slug', 'model', 'icon'];
    public $with = ['posts'];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('id', 'desc');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }

}
