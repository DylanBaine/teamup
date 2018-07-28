<?php
Route::prefix('auth')->group(function () {
    $controller = 'CustomAuthController@';
    Route::post('login', $controller . 'login');
    Route::post('logout', $controller . 'logout');
    Route::post('register', $controller . 'register');
});

// Reset the default password of a user
Route::post('set_new_password', function (Request $request) {
    $user = user();
    $user->password = bcrypt(request('password'));
    $user->password_confimed = 1;
    $user->save();
    return redirect()->back();
});

// Return the session user
Route::get('/auth/user', function () {
    $user = Auth::user();
    $user->company = App\Models\Company::find($user->company_id);
    return $user;
});
