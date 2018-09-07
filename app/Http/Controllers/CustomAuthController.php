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
            return 1;
        }
        return $this->errorBag($request);

    }

    protected function errorBag(Request $request){
        if(!$request->email){
            return "Please enter an email address.";
        }
        if(User::where('email', $request->email)->exists()){
            return "Your password is incorrect.";
        }
        return "A user with this email doesn't exist.";
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
