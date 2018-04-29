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

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function postTypes()
    {
        return $this->belongsToMany(Type::class, 'permission_post_type');
    }
}
