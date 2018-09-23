<?php
//dd(bcrypt('secret'));
Route::get('app-redirect', function(){
    $ref = request()->query('ref');
    $to = request()->query('to');
    return redirect(url('app#/'.$to));
});
// Set users last page with every request
Route::post('set_last_page', function(){
    user()->last_route = request('route');
    user()->save();
    return user()->load('permissions', 'tasks', 'columns');
})->middleware('auth');
//Search Route
Route::get('toolbar-search', 'SearchController@index');
//Marketing site routes
include 'marketingRoutes.php';
// Return the layout view when visiting the app
Route::get('/app', function () {
    $user = Auth::user() ? Auth::user()->load('groups', 'permissions', 'tasks', 'columns') : false;
    if ($user) {
        $user->company = App\Models\Company::find($user->company_id);
    }
    $users_collection = company()->users()->get();
    $company = company()->load('superUser');
    return view('layouts.app', compact('user', 'users_collection', 'company'));
})->middleware('auth');
Route::get('/search', 'SearchController');
// Overwrite laravel auth routes for cusotom api login and logout
include 'authRoutes.php';
// Include api routes for users module
include 'userRoutes.php';
    // Include contact rotues
    include 'contactRoutes.php';
Route::middleware('permissions')->group(function(){
    // Include api routes for posts module
    include 'postRoutes.php';
    // Include Client Rotes
    include 'clientRoutes.php';
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
    
    Route::resource('reports', 'ReportController');
});
// Handle all search methods