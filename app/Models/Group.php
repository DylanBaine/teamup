<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $with = ['users', 'permissions', 'files'];
    protected $fillable = ['name'];

    public function users(){
        return $this->hasMany(Models\User::class);
    }

    public function permissions(){
        return $this->hasMany(Models\Permission::class);
    }

    public function files(){
        return $this->hasMany(Models\File::class);
    }

}
