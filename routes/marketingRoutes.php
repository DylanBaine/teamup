<?php
Route::get('/', function () {
    return view('marketing.index');
});

Route::get('/login', function () {
    return view('marketing.login');
})->name('login');

Route::get('/register', function () {
    return view('marketing.register');
})->name('register');

Route::get('/pricing', function(){
    return view('marketing.pricing');
});