<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $fillable = [
        'user_id', 'subscribable_id', 'subscribable_type',
    ];
    public function subscribables()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
