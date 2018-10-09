<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledActivity extends Model
{
    protected $fillable = [
        'type', 'time', 'day', 'week', 'schedulable_type', 'schedulable_id'
    ];
}
