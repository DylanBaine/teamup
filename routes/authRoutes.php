<?php
Route::prefix('auth')->group(function () {
    $controller = 'CustomAuthController@';
    Route::post('login', $controller . 'login');
    Route::post('logout', $controller . 'logout');
});
