<?php
Route::resource('/tasks', 'TaskController');
Route::get('/tasks/{task}/add', 'TaskController@add');
Route::get('/tasks/{task}/add-file/{file}', 'TaskController@attachFile');
Route::get('/tasks/{task}/remove-file/{file}', 'TaskController@detachFile');
Route::get('tasks/user_availability/{user}', function($user){
    $tasks = App\Models\Task::with('type')->where('user_id', $user)
        ->whereHas('type', function($type){
            return $type->where('name', 'Task');
        })->orderBy('start_date')->get();
    $events = [];
    $unfinishedTasks = [];
    foreach($tasks as $task){
        if($task->column->value != 'Finished'){
            $events[] = carbon_days_between($task->start_date, $task->end_date);
            $unfinishedTasks[] = $task;
        }
    }
    return response()->json([
        'tasks' => $unfinishedTasks,
        'events' => array_flatten($events)
    ]);
}); 