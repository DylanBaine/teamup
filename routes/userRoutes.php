<?php
Route::resource('users', 'UserController');

Route::get('set-password', function(){
    return view('set-password');
})->middleware('auth');

Route::post('set-password', function(){ 
    user()->password = bcrypt(request('password'));
    user()->password_confirmed = 1;
    user()->save();
    return redirect('/app');
});
