<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    //public $with = ['type'];
    protected $fillable = ['name', 'content', 'type_id', 'site_id', 'company_id'];

    public function belongsToUser()
    {
        return $this->user_id == \Auth::user()->id;
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable');
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
