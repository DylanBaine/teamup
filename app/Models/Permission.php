<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $with = ['posts', 'postTypes'];
    protected $fillable = ['mode'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

}
