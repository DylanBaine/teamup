<?php
// Return the layout view when visiting the app
Route::get('/', function () {
    return view('layouts.app');
});

// Return the session user
Route::get('/auth-user', function () {
    return Auth::user();
});

// Handle all search methods
Route::get('/search', 'SearchController');

// Include all laravel auth routes
Auth::routes();
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
