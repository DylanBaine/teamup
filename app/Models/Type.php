<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name', 'slug', 'model', 'icon', 'company_id'];
    public $with = ['posts'];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->where('company_id', company('id'))->orderBy('id', 'desc');
    }

    public function files()
    {
        return $this->hasMany(File::class)->where('company_id', company('id'));
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable')->where('company_id', company('id'));
    }

}
