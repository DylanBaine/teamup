<?php
namespace App\Timmatic\BLL;

use App\Models\Setting;
use App\Models\User;
use App\Models\Task;
use Notification;
use App\Models\Subscription;
use App\Notifications\TaskUpdated;

trait TaskLogic
{

    function taskNotification($taskId, $methodString){
      $task = Task::find($taskId);
        $users = User::whereHas('subscriptions', function ($sub) use ($task) {
            $sub->where('subscribable_id', $task->id)->where('subscribable_type', 'App\Models\Task');
        })->get();
        Notification::send($users, new TaskUpdated($task, null, $methodString));
    }

    function addColumn()
    {
        $taskId = request()->query('id');

        Setting::create([
            'company_id' => company('id'),
            'name' => 'column',
            'value' => request('value'),
            'position' => request('position'),
            'settable_id' => $taskId,
            'settable_type' => 'App\Models\Task'
        ]);
        
            $this->taskNotification($taskId, 'addColumn');
    }

    function removeColumn($id)
    {
        $setting = Setting::where('id', $id)->first();
        $setting->delete();
        $taskId = Task::whereHas('settings', function($setting) use ($id){
            $setting->where('id', $id);
        })->first()->id;
        $this->taskNotification($taskId, 'removeColumn');

    }

    function removeUserFromColumn($setting)
    {
        $sub = Subscription::where('id', $setting)->first();
        $users = User::where('id', $sub->user_id)->get();
        $task = Task::find($sub->subscribable_id);
        Notification::send($users, new TaskUpdated($task, null, 'unsubscribedFromTask'));
        $sub->delete();
    }

    function subscribeUserToTask($task = null)
    {
        $taskId = request('subscribable_id') && ! $task ? request('subscribable_id') : $task->id;
        $users = User::where('id', request('user_id'))->get();
        $task = Task::find($taskId);
        $data = [
                'user_id' => request('user_id'),
                'subscribable_type' => 'App\Models\Task',
                'subscribable_id' => $task->id
        ];
        $sub = Subscription::where($data);
        if(!$sub->exists()){
            Subscription::create($data);
            Notification::send($users, new TaskUpdated($task, null, 'subscribedToTask'));
        }
    }

}
