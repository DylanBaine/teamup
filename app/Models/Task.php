<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function __construct(array $attributes = [])
    {

    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsTo(User::class);
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class);
    }

    public function type()
    {
        return $this->hasOne(Type::class);
    }

    public function parent()
    {
        return $this->hasOne(Task::class, 'perent_id');
    }

    public function children(){
        return $this->hasMany(Task::class, 'tasks', 'parent_id');
    }
}
