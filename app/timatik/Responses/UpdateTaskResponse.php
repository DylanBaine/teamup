<?php
namespace App\timatik\Responses;

use App\Models\Setting;
use App\Models\Task;
use App\Models\ProgressChange;
use App\Notifications\TaskUpdated;
use Illuminate\Contracts\Support\Responsable;
use Notification;
use App\Models\User;
use Carbon\Carbon;
use App\timatik\BLL\TaskLogic;
use App\Models\ScheduledActivity;

class UpdateTaskResponse implements Responsable
{

    use TaskLogic;

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
        $t->group_id = $request->group_id;
        $t->icon = $request->icon;
        $t->end_date = $request->end_date;
        $t->start_date = $request->start_date;
        $t->client_id = $request->client_id;
        $t->save();
        $type = $t->type->name;
        if($request->user_id){
            $this->subscribeUserToTask($t);
        }
        if($request->wants_columns){
            $t->createDefaultSettings();
        }else{
            $t->settings()->delete();
        }
        if($type == 'Reoccurring'){
            $this->scheduleReoccurringActivity(json_decode($request->schedule), $t->id);
        }else{
            ScheduledActivity::where('schedulable_type', 'Task')->where('schedulable_id', $t->id)->delete();
        }
        if($request->progressChange){
            $this->updateProgress($t);
        }else{
            $this->notifyOfEdit($t);
        }
    }

    protected function getUsersToNotify($task, $parent = null){
        if($parent){
            return User::whereHas('subscriptions', function ($sub) use ($parent, $task) {
                $sub->where('subscribable_id', $parent->id)->where('subscribable_type', 'App\Models\Task')->orWhere('subscribable_id', $task->id);
            })->where('id', '!=', user('id'))->get();
        }
        return User::whereHas('subscriptions', function ($sub) use ($task) {
            $sub->where('subscribable_id', $task->id)->orWhere('subscribable_id', $task->parent_id)->where('subscribable_type', 'App\Models\Task');
        })->where('id', '!=', user('id'))->get();
    }

    protected function notifyOfEdit($task){
        Notification::send($this->getUsersToNotify($task), new TaskUpdated($task, null, 'dataUpdated', user()));
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
        $this->logProgressChange($task, $parent);
        Notification::send($this->getUsersToNotify($task, $parent), new TaskUpdated($task, $parent, 'progressUpdated', user()));
    }

    // i wish i would have just made this a task change so i could just log any edits to the task....
    protected function logProgressChange($task){
        $previous = $task->changes()->orderBy('created_at', 'desc')->first();
        if($previous){
            ProgressChange::create([
                'task_id' => $task->id,
                'column_id' => $task->column->id,
                'user_id' => user('id'),
                'duration_in_seconds' => 0
                ]);
                $previous->duration_in_seconds = $previous->created_at->diffInSeconds(Carbon::now());
                $previous->save();
            }
    }

    private function scheduleReoccurringActivity($schedule, $taskId){
        ScheduledActivity::where('schedulable_type', 'Task')->where('schedulable_id', $taskId)->delete();
        ScheduledActivity::create([
            'type' => $schedule->type,
            'time' => $schedule->time,
            'day' => $schedule->day,
            'week' => $schedule->week,
            'schedulable_type' => 'Task',
            'schedulable_id' => $taskId
        ]);
    }

}
