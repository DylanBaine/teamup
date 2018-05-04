<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;
    // public $with = ['permissions', 'posts'];
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function availableGroups()
    {
        $allGroups = Group::all();
        $available = new Collection([]);
        foreach ($allGroups as $group) {
            if ($group->availableToUser($this)) {
                $available[] = $group;
            }
        }
        return $available;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function edits()
    {
        return $this->belongsTo(Edit::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
