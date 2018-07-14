<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $fillable = [
        'name', 'value', 'settable_id', 'settable_type', 'position', 'company_id'
    ];
    public function settables()
    {
        return $this->morphTo();
    }
}
