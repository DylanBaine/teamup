<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\TEAMUP\Responses\UpdateTaskResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public $company;
    public function __construct()
    {
        $this->middleware('permissions');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return company()->tasks()->where('parent_id', null)->with('children', 'type')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parent = Task::find($request->parent_id);
        $t = new Task;
        $t->company_id = company('id');
        $t->name = $request->name;
        $t->description = $request->description == null ? 'No Description Given' : $request->description;
        $t->parent_id = $request->parent_id;
        $t->type_id = $request->type_id;
        $t->user_id = $request->user_id;
        $t->icon = $request->icon;
        $t->percent_finished = 0;
        $t->column_id = $parent && $parent->columns()->count() ?
        $parent->columns()->first()->id :
        null;
        $t->save();
        if ($t->type->name === 'Sprint') {
            $t->createDefaultSettings();
        }
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = company()->tasks()->find($id)->load('columns', 'user', 'subscribers', 'children', 'type');
        $task->parent = Task::find($task->parent_id);
        return $task;
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
        return (new UpdateTaskResponse)->toResponse($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task->parent_id == null || $task->parent_id == 0) {
            foreach ($task->children()->get() as $child) {
                $child->parent_id = 0;
                $child->save();
            }
        }
        $task->delete();
    }
}
