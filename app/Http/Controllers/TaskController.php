<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Timmatic\Responses\UpdateTaskResponse;
use Illuminate\Http\Request;
use App\Models\ProgressChange;
use App\Timmatic\BLL\TaskLogic;
class TaskController extends Controller
{

    use TaskLogic;

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

    public function create(){
        return response()->json([
            'users' => company()->users,
            'groups' => company()->groups,
            'types' => company()->types()->where('model', 'Task')->get()
        ]);
    }

    public function edit($id){
        return response()->json([
            'users' => company()->users,
            'groups' => company()->groups,
            'types' => company()->types()->where('model', 'Task')->get(),
            'task' => Task::find($id)->load('user', 'group'),
            'parent' => Task::find($id)->parent
        ]);
    }

    public function add($parentId){
        $parent = Task::find($parentId);
        return response()->json([
            'users' => company()->users,
            'groups' => company()->groups,
            'types' => company()->types()->where('model', 'Task')->get(),
            'parent' => $parent,
            'allowed_dates' => $dates
        ]);        
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
        $t->group_id = $request->group_id;
        $t->icon = $request->icon;
        $t->percent_finished = 0;
        $t->column_id = $parent && $parent->columns()->count() ?
        $parent->columns()->first()->id :
        null;
        $t->report = 0;
        $t->start_date = $request->start_date ? carbon_format($request->start_date) : null;
        $t->end_date = $request->end_date ? carbon_format($request->end_date) : null;
        $t->save();
        $t->linkReport();
        if($request->user_id){
            $this->subscribeUserToTask($t);
        }
        if ($t->type->name === 'Sprint') {
            $t->createDefaultSettings();
        }
        if($t->column){
            ProgressChange::create([
                'task_id' => $t->id,
                'column_id' => $t->column->id,
                'user_id' => user('id'),
                'duration_in_seconds' => 0
                ]);
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
        $task = company()->tasks()->find($id)->load('columns', 'user', 'subscribers', 'children', 'type', 'changes', 'group');
        $task->report = $task->runReport();
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
                $parentName = $task->name;
                $child->parent_id = null;
                $child->description .= "<p>(once a child to $parentName)</p>";
                $child->save();
            }
        }
        $task->delete();
    }
}
