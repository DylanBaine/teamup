<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\TEAMUP\Auth\UserCreation;

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
            $user = Auth::user()->load('permissions', 'groups');
            $user->company = \App\Models\Company::find($user->company_id);
            return response()->json($user);
        } else {
            return abort(404, "I'm sorry... This info didn't match our records...");
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
