<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edit extends Model
{
    //public $with = ['users', 'posts'];
    protected $fillable = ['user_id', 'post_id', 'details'];

    public function users()
    {
        return $this->hasOne(Models\User::class);
    }

    public function posts()
    {
        return $this->belongsTo(Model\Post::class);
    }
}
