<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MimeType extends Model
{
    protected $fillable = ['name', 'slug'];

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
