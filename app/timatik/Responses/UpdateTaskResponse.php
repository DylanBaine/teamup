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
        if($type == 'Sprint'){
            $t->createDefaultSettings();
        }
        if($type == 'Reoccurring'){
            $this->scheduleReoccurringActivity(json_decode($request->schedule), $t->id);
        }
        if($request->progressChange){
            $this->updateProgress($t);
        }else{
            $this->notifyOfEdit($t);
        }
    }

    protected function notifyOfEdit($task){
        $users = User::whereHas('subscriptions', function ($sub) use ($task) {
            $sub->where('subscribable_id', $task->id)->orWhere('subscribable_id', $task->parent_id)->where('subscribable_type', 'App\Models\Task');
        })->get();
        Notification::send($users, new TaskUpdated($task, null, 'dataUpdated', user()));
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
        $users = User::whereHas('subscriptions', function ($sub) use ($parent, $task) {
            $sub->where('subscribable_id', $parent->id)->where('subscribable_type', 'App\Models\Task')->orWhere('subscribable_id', $task->id);
        })->get();
        $this->logProgressChange($task);
        Notification::send($users, new TaskUpdated($task, $parent, 'progressUpdated', user()));
    }

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
