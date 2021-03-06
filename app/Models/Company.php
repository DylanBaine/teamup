<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'super_user_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function superUser()
    {
        return $this->belongsTo(User::class, 'super_user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function permissionModes($name = null)
    {
        $relation = $this->hasMany(PermissionMode::class);
        return $name == null ? $relation : $relation->where('name', $name)->first();
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function types($slug = null)
    {
        if($slug != null){
            return $this->hasMany(Type::class)->where('slug', $slug)->first();
        }
        return $this->hasMany(Type::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function edits()
    {
        return $this->hasMany(Edit::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function clients(){
        return $this->hasMany(Client::class);
    }
}
