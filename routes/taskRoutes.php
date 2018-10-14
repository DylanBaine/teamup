<?php
Route::resource('/tasks', 'TaskController');
Route::get('/tasks/{task}/add', 'TaskController@add');
Route::get('/tasks/{task}/add-file/{file}', 'TaskController@attachFile');
Route::get('/tasks/{task}/remove-file/{file}', 'TaskController@detachFile');
Route::get('tasks/user_availability/{user}', function($user){
    return App\Models\User::find($user)->tasks;
});