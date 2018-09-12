<?php
use App\PasswordReset;
use App\Models\User;
Route::resource('users', 'UserController');

Route::get('set-password', function(){
    if(request()->query('token')){
        $user = User::where('email', PasswordReset::where('token', request()->query('token'))->first()->email)->first();
    }else{
        $user = null;
    }
    return view('set-password', compact('user'));
})->middleware('guest');

Route::post('set-password', function(){
    $user = User::where('email', request('email'))->first();
    if($user == null){
        return redirect()->back()->with('error', 'A user with that email was not found.');
    }
    if(request('password')){
        $user->password = bcrypt(request('password'));
        $user->password_confirmed = 1;
        $user->save();
        \Auth::login($user);
        return redirect('/app')->with('success', 'Successfully updated password!');
    }else{
        $token = $user->createPasswordReset();
        $user->sendPasswordResetNotification($token);
        return redirect('/login')->with('success', 'Password reset link sent! Check your email.');
    }
})->middleware('guest');
