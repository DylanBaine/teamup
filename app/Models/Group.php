<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Reports\GroupReport;

class Group extends Model
{
    //public $with = ['users', 'permissions', 'files'];
    protected $fillable = ['name', 'company_id'];

    public function toArray(){
        $data = parent::toArray();
        $data['report'] = (new GroupReport(['id' => $this->id]))->getData();
        return $data;
    }

    public function recursivGetTasks($task = null){
        $children = $task == null ? $this->tasks()->with('children')->get() : $task->children()->with('children')->get();
            foreach($children as $child){
                $children->push($this->recursivGetTasks($child));
            }
            return ($children->flatten(1));
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class)->with('parent', 'type');
    }

    public function availableToUser($user)
    {
        return $this->users->find($user->id) == null;
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
