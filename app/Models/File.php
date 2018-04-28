<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $with = ['users', 'groups'];

    protected $fillable = ['name', 'slug', 'user_id', 'group_id'];

    public function users(){
        return $this->belongsTo(Models\User::class);
    }

    public function groups(){
        return $this->belongsTo(Models\Group::class);
    }
}
