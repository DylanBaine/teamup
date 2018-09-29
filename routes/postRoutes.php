<?php
Route::resource('posts', 'PostController');
Route::get('{type}', function($type){
    return \App\Models\Type::where('model', 'Post')->where('slug', $type)->with('posts')->first();
});
