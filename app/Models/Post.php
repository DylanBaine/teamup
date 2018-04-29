<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public $with = ['type'];
    protected $fillable = ['name', 'content', 'user_id'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function edits()
    {
        return $this->hasMany(Edit::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
