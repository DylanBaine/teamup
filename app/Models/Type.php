<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Models\Post::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
