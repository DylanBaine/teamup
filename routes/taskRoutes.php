<?php
Route::resource('/tasks', 'TaskController');
Route::get('/tasks/{task}/add', 'TaskController@add');
Route::get('/tasks/{task}/add-file/{file}', 'TaskController@attachFile');
Route::get('/tasks/{task}/remove-file/{file}', 'TaskController@detachFile');
Route::get('tasks/user_availability/{user}', function($user){
    $tasks = App\Models\User::find($user)->tasks;
    $events = [];
    foreach($tasks as $task){
        if($task->type->name == 'Task'){
            $events[] = carbon_days_between($task->start_date, $task->end_date);
        }
    }
    return response()->json([
        'tasks' => $tasks,
        'events' => array_flatten($events)
    ]);
}); 