<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::prefix('/home')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UserController');
        Route::resource('posts', 'PostController');
        Route::resource('types', 'TypeController');
        Route::resource('files', 'FileController');
        Route::resource('groups', 'GroupController');
        Route::post('groups/manage/users/{user}', 'GroupController@addUser');
        Route::delete('groups/{group}/remove/{user}', 'GroupController@removeUser');
    });
});
