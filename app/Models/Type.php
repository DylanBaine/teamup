<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name', 'slug', 'model'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
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
