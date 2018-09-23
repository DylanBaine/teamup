<?php
Route::get("/file-type/{type}", "FileController@getType");
Route::resource('files', 'FileController');
