<?php
//Marketing site routes
include 'marketingRoutes.php';
// Return the layout view when visiting the app
Route::get('/app', function () {
    $user = Auth::user() ? Auth::user()->load('groups', 'permissions', 'tasks', 'columns') : false;
    if ($user) {
        $user->company = App\Models\Company::find($user->company_id);
    }
    return view('layouts.app', compact('user'));
})->middleware('auth');
// Handle all search methods
Route::get('/search', 'SearchController');
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
// include api routes for settings
include 'settingRoutes.php';
// include api routes for permission modes
include 'permissionRoutes.php';
// include api routes for sites
include 'siteRoutes.php';
