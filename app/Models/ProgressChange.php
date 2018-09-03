<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressChange extends Model
{
    protected $fillable = [
        'column_id', 'task_id', 'user_id', 'duration_in_seconds'
    ];

    public function toArray(){
        $change = parent::toArray();
        $change['change_date'] = $this->created_at->diffForHumans();
        $change['user'] = $this->user;
        return $change;
    }

    public function column(){
        return $this->belongsTo(Setting::class, 'column_id');
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
