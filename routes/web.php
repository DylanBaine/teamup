<?php
// Return the layout view when visiting the app
Route::get('/', function () {
    $user = Auth::user() ? Auth::user()->load('groups', 'permissions', 'tasks') : false;
    return view('layouts.app', compact('user'));
});

// Return the session user
Route::get('/auth/user', function () {
    return Auth::user();
});

// Handle all search methods
Route::get('/search', 'SearchController');

// Include all laravel auth routes if needed
//Auth::routes();
// Overwrite laravel auth routes for cusotom api login and logout
include 'authRoutes.php';
// Include api routes for users module
include 'userRoutes.php';
// Include api routes for posts module
include 'postRoutes.php';
// Include api routes for types module
include 'typeRoutes.php';
// Include api routes for files module
include 'fileRoutes.php';
// Include api routes for groups module
include 'groupRoutes.php';
// include api routes for tasks module
include 'taskRoutes.php';

Route::post('/settings', function () {
    $querys = request()->query();
    $keys = collect([]);
    $values = collect([]);
    foreach ($querys as $key => $value) {
        $keys->push($key);
        $values->push($value);
    }
    dd($values);
});
