<?php
Route::resource('/tasks', 'TaskController');
Route::get('/tasks/{task}/add', 'TaskController@add');