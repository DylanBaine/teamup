<?php
Route::resource('groups', 'GroupController');
Route::post('groups/manage/users/{user}', 'GroupController@addUser');
Route::delete('groups/{group}/remove/{user}', 'GroupController@removeUser');
Route::get('groups/calendar/{group}/{month?}', 'GroupController@calendar');
