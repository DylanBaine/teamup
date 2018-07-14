<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //public $with = ['users', 'groups'];
    protected $fillable = ['name', 'slug', 'type', 'hash_name', 'company_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }
}
