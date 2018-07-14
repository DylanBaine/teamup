<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companys';

    public function users()
    {
        return $this->hasMany(User::class);
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

    public function permissionModes()
    {
        return $this->hasMany(PermissionMode::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function types()
    {
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
}
