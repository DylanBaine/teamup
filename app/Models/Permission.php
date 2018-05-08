<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $with = ['posts', 'postTypes'];
    protected $fillable = ['mode'];

    public function users()
    {
        return $this->morphedByMany(User::class, 'permissable');
    }

    public function groups()
    {
        return $this->morphedByMany(Group::class, 'permissable');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'permissable');
    }

    public function types()
    {
        return $this->morphedByMany(Type::class, 'permissable');
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
