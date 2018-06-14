<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionMode extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
