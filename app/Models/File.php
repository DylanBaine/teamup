<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $with = ['users', 'groups'];
    protected $fillable = ['name', 'slug', 'type', 'hash_name'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function ype()
    {
        return $this->belongsTo(Type::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
