<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
//use App\TEAMUP\AssertIsSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    private $groups, $assertDB, $users;

    public function __construct()
    {
        $this->groups = Group::all();
        //$this->assertDb = new AssertIsSet('groups');
        $this->users = User::all();
    }

    public function addUser(Request $request, $user)
    {
        $group = Group::find($request->group);
        $user = User::find($user);
        $group->users()->save($user);
        return redirect()->back();
    }

    public function removeUser($group, $user)
    {
        DB::table('group_user')->where('user_id', $user)->where('group_id', $group)->delete();
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::get();
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
            'name' => $request->name,
        ]);
        //return $this->assertDb->has('id', $group->id);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = $this->groups->find($id);
        return view('groups.show', compact('group'));
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
