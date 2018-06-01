<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionMode extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
