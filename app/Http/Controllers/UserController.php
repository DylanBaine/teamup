<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserCreated;
use Illuminate\Http\Request;
use Notification;

class UserController extends Controller
{

    protected $allUsers;
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return company()->users()->with('tasks')->get();

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'user' => User::find($id)->load('permissions', 'tasks', 'columns'),
            'modes' => company()->permissionModes()->get(),
            'types' => company()->types()->get()
        ]);
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('secret');
        $user->company_id = company('id');
        if ($user->save()) {
            $user->createPasswordReset();
            $user->createDefaultSettings();
            Notification::send($user, new UserCreated($user->name, $user->getPasswordToken(), company('name')));
        };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->users->find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->users->destroy($id);
    }
}
