<?php

namespace App\Console\Commands\Cron;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use App\Notifications\TasksComingUpNotification;

class NotifyTaskUsersWhenTaskIsDueOrStarted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:notify_users_of_started_and_due_tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(User::get() as $user){
            $nofications = $this->tasksComingUpForUser($user);
            //dd($nofications);
            $hasNotifications = count($nofications->startingTomorrow) || count($nofications->dueTomorrow)
            || count($nofications->startingToday) || count($nofications->dueToday);
            if($hasNotifications){
                $user->notify(new TasksComingUpNotification($nofications));
            }
        }
    }

    private function tasksComingUpForUser(User $user){
        $tasks = $user->tasks()->orderBy('start_date', 'desc')->get();
        $commingUp = plain_object([
            'startingTomorrow' => [],
            'dueTomorrow' => [],
            'startingToday' => [],
            'dueToday' => [],
        ]);
        $today = new Carbon(Carbon::now()->toDateString());
        foreach($tasks as $task){
            if($task->start_date->diffInDays($today) == 1 && $task->start_date->gt($today)){
                $commingUp->startingTomorrow[] = plain_object([
                    'task' => $task
                ]);
            }
            if($task->start_date->diffInDays($today) == 0){
                $commingUp->startingToday[] = plain_object([
                    'task' => $task
                ]);
            }
            if($task->end_date->diffInDays($today) == 1 && $task->end_date->gt($today)){
                $commingUp->dueTomorrow[] = plain_object([
                    'task' => $task
                ]);
            }
            if($task->end_date->diffInDays($today) == 0){
                $commingUp->dueToday[] = plain_object([
                    'task' => $task
                ]);
            }
        }
        return $commingUp;
    }
}
