<?php
Route::get('{type}/{post}/edit', 'PostController@edit');
Route::resource('posts', 'PostController');
Route::get('{type}', function($type){
    return \App\Models\Type::where('model', 'Post')->where('slug', $type)->with('posts')->first();
});
Route::get('{type}/{post}', 'PostController@show');

