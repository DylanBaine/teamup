<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
//use App\timatik\AssertIsSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    private $groups, $assertDB, $users;

    public function __construct()
    {
    }

    public function addUser(Request $request, $user)
    {
        $group = Group::find($request->group);
        $user = User::find($user);
        abort_if(
            DB::table('group_user')->where('user_id', $user->id)->where('group_id', $group->id)->exists(), 
            422, 
            $user->name.' is already assigned to '.$group->name.'.'
        );
        $group->users()->save($user);
    }

    public function removeUser($group, $user)
    {
        DB::table('group_user')->where('user_id', $user)->where('group_id', $group)->delete();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return company()->groups()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Group::create([
            'company_id' => company('id'),
            'name' => $request->name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return company()->groups()->find($id)->load('users', 'tasks');
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
        $this->groups->find($id)->update([
            'name' => $request->name,
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
        $this->groups->delete($id);
    }
}
