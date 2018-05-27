<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            $response = Auth::user()->load('permissions', 'groups');
        } else {
            $response = ['success' => false, 'error' => 'I\'m sorry... This info didn\'t match up... Try again.'];
        }
        return response()->json($response);
    }

    public function logout()
    {
        Auth::logout();
    }
}
