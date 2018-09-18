<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //public $with = ['users', 'permissions', 'files'];
    protected $fillable = ['name', 'company_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class)->with('parent', 'type');
    }

    public function availableToUser($user)
    {
        return $this->users->find($user->id) == null;
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
