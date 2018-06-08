<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $fillable = [
        'name', 'value', 'settable_id', 'settable_type', 'position'
    ];
    public function settables()
    {
        return $this->morphTo();
    }
}
