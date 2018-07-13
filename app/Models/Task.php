<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'type_id', 'user_id', 'parent_id', 'percent_finished'];

    public function __construct(array $attributes = [])
    {

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsTo(User::class);
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'perent_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id', 'id');
    }

    public function settings($name = null)
    {
        if ($name != null) {
            return $this->morphMany(Setting::class, 'settable')->where('name', $name)->orderBy('position');
        }
        return $this->morphMany(Setting::class, 'settable')->orderBy('position');
    }

    public function columns()
    {
        return $this->settings('column');
    }

    public function subscribers()
    {
        return $this->morphMany(Subscription::class, 'subscribable')->with('user');
    }

}
