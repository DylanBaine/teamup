<?php

namespace App\Models;

use App\Models\Group;
use App\PasswordReset;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'email', 'company_id', 'password', 'password_confirmed'];
    protected $hidden = ['password', 'remember_token'];
    protected $defalutSettings = [
        'column' => 'Back Log',
        'column' => 'In Progress',
        'column' => 'Finished',
    ];

    public function settings($name = null)
    {
        if ($name != null) {
            return $this->morphMany(Setting::class, 'settable')->where('name', $name)->orderBy('position');
        }
        return $this->morphMany(Setting::class, 'settable')->orderBy('position');
    }

    public function getPasswordToken(){
        return PasswordReset::where('email', $this->email)->first()->token;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this->name, $token));
    }

    public function createPasswordReset(){
        \DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => str_random(40) . $this->id,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return \DB::table('password_resets')->where('email', $this->email)->orderBy('created_at', 'desc')->first()->token;
    }

    public function createDefaultSettings()
    {
        Setting::create([
            'company_id' => company('id'),
            'name' => 'column',
            'value' => 'Back Log',
            'settable_id' => $this->id,
            'position' => 1,
            'settable_type' => 'App\Models\User',
        ]);
        Setting::create([
            'company_id' => company('id'),
            'name' => 'column',
            'value' => 'In Progress',
            'settable_id' => $this->id,
            'position' => 2,
            'settable_type' => 'App\Models\User',
        ]);
        Setting::create([
            'company_id' => company('id'),
            'name' => 'column',
            'value' => 'Finished',
            'settable_id' => $this->id,
            'position' => 3,
            'settable_type' => 'App\Models\User',
        ]);
    }

    public function columns()
    {
        return $this->settings('column');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->take(5);
    }

    public function availableGroups()
    {
        $allGroups = Group::all();
        $available = new Collection([]);
        foreach ($allGroups as $group) {
            if ($group->availableToUser($this)) {
                $available[] = $group;
            }
        }
        return $available;
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function edits()
    {
        return $this->belongsTo(Edit::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->with('column', 'type');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
