<?php
namespace App\TEAMUP\Responses;

use App\Models\Setting;
use App\Models\Task;
use App\Notifications\TaskUpdated;
use Illuminate\Contracts\Support\Responsable;
use Notification;
use App\Models\User;

class UpdateTaskResponse implements Responsable
{

    public function toResponse($request)
    {
        $id = $request->id;
        $t = Task::find($id);
        $t->name = $request->name;
        $t->description = $request->description == null ? 'No Description Given' : $request->description;
        $t->parent_id = $request->parent_id;
        $t->column_id = $request->column_id ? $request->column_id : $t->column_id;
        $t->type_id = $request->type_id;
        $t->user_id = $request->user_id;
        $t->icon = $request->icon;
        $t->save();
        if ($request->parent_id !== null) {
            $this->updateProgress($t);
        }
        if($t->type->name == 'Sprint'){
            $t->createDefaultSettings();
        }   
    }

    protected function updateProgress($task)
    {
        $parent = Task::find($task->parent_id);
        $childrentCount = $parent->children()->count();
        $finishedColumnId = Setting::where('value', 'Finished')->where('settable_id', $parent->id)->first();
        if($finishedColumnId){
            $finishedColumnId = $finishedColumnId->id;
        }
        $finishedTaskCount = $parent->children()->where('column_id', $finishedColumnId)->count();
        $percent = ($finishedTaskCount / $childrentCount) * 100;
        $parent->percent_finished = $percent;
        $parent->save();
        $users = User::whereHas('subscriptions', function ($sub) use ($parent) {
            $sub->where('subscribable_id', $parent->id)->where('subscribable_type', 'App\Models\Task');
        })->get();
        Notification::send($users, new TaskUpdated($task, $parent));
    }

}
