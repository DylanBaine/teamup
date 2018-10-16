<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Task extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'start_date', 'end_date'];

    protected $fillable = ['name', 'description', 'type_id', 'user_id', 'parent_id', 'percent_finished'];

    protected $with = ['parent'];

    protected $defalutSettings = [
        'column' => 'Back Log',
        'column' => 'In Progress',
        'column' => 'Finished',
    ];
    
    public function __construct(array $attributes = [])
    {
        parent::__construct();
    }

    public function toArray(){
        $t = parent::toArray();
        $t['start_date'] = $this->start_date != null ? (new Carbon($t['start_date']))->toDateString() : null;
        $t['end_date'] = $this->end_date != null ? (new Carbon($t['end_date']))->toDateString() : null;
        $t['start_date_string'] = $this->start_date != null ? (new Carbon($t['start_date']))->toFormattedDateString() : null;
        $t['end_date_string'] = $this->end_date != null ? (new Carbon($t['end_date']))->toFormattedDateString() : null;
        $t['calc_percent_finished'] = $this->calcPercentFinished();
        return $t;
    }

    public function calcPercentFinished(){
        if($this->columns()->count() && $this->children()->count()){
            $finishedId = $this->columns()->where('value', 'Finished')->first()->id;
            $finishedCount = $this->children()->where('column_id',  $finishedId)->count();
            return ceil(($finishedCount/$this->children()->count())*100);
        }else{
            return 0;
        }
    }

    public function runReport(){
        if($this->report){
            $file_name = "App\Reports\\".$this->report;
            $args = [
                'id' => $this->id
            ];
            $class_instance = new $file_name($args);
            return $class_instance->getData();
        }
    }

    public function linkReport(){
        $type = $this->type->name;
        if($type == 'Task'){
            $r = 'BasicTaskReport';
        }elseif($type == 'Sprint'){
            $r = 'SprintReport';
        }elseif($type == 'Team'){
            $r = 'TeamReport';
        }elseif($type == 'Project'){
            $r = 'ProjectReport';
        }else{
            $r = 'ReoccurringTaskReport';
        }
        $this->report = $r;
        $this->save();
    }
    public function createDefaultSettings()
    {

        if(!$this->columns->count()){
            Setting::create([
                'company_id' => company('id'),
                'name' => 'column',
                'value' => 'Back Log',
                'settable_id' => $this->id,
                'position' => 1,
                'settable_type' => 'App\Models\Task',
            ]);
            Setting::create([
                'company_id' => company('id'),
                'name' => 'column',
                'value' => 'In Progress',
                'settable_id' => $this->id,
                'position' => 2,
                'settable_type' => 'App\Models\Task',
            ]);
            Setting::create([
                'company_id' => company('id'),
                'name' => 'column',
                'value' => 'Finished',
                'settable_id' => $this->id,
                'position' => 3,
                'settable_type' => 'App\Models\Task',
            ]);
        }
    }

    public function files(){
        return $this->belongsToMany(File::class);
    }

    public function schedule(){
        return $this->hasOne(ScheduledActivity::class, 'schedulable_id')->where('schedulable_type', 'Task');
    }

    public function changes(){
        return $this->hasMany(ProgressChange::class)->with('column')->orderBy('created_at', 'desc');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
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
        return $this->belongsTo(Task::class);
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id', 'id')->with('type', 'client')->orderBy('start_date');
    }

    public function settings($name = null)
    {
        if ($name != null) {
            return $this->morphMany(Setting::class, 'settable')->where('name', $name)->orderBy('position');
        }
        return $this->morphMany(Setting::class, 'settable')->orderBy('position');
    }

    public function columns($value = null)
    {
        if($value != null){
            return $this->settings('column')->where('value', $value);
        }
        return $this->settings('column');
    }

    public function column(){
        return $this->belongsTo(Setting::class)->where('name', 'column');
    }

    public function subscribers()
    {
        return $this->morphMany(Subscription::class, 'subscribable')->with('user');
    }

}
