<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $with = ['type', 'permissionMode'];
    protected $fillable = ['mode'];

    public function permissionMode()
    {
        return $this->belongsTo(PermissionMode::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
/*
public function users()
{
return $this->morphedByMany(User::class, 'permissable');
}
 */
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'permissable');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'permissable')->take(10);
    }

    public function types()
    {
        return $this->morphedByMany(Type::class, 'permissable')->take(10);
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'permissable');
    }

    public function tasks()
    {
        return $this->morphedByMany(Task::class, 'permissable');
    }

}
