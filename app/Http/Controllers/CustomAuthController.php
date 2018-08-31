<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\TEAMUP\Auth\UserCreation;
use Auth;
use Illuminate\Http\Request;

class CustomAuthController extends Controller
{
    private $user;
    public function __construct(Request $request)
    {
        $this->user = User::where('email', $request->email)->first();
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(!user()->password_confirmed){
                return redirect('set-password');
            }
            return redirect('/app');
        }
        else{
            about(403, 'The given data was invalid');
        }

    }

    public function register(Request $request)
    {
        return (new UserCreation($request))->response();
    }

    public function logout()
    {
        Auth::logout();
    }
}
