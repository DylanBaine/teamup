<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\timatik\Responses\UpdateTaskResponse;
use App\timatik\Responses\CreateTaskResponse;
use App\timatik\Responses\DeleteTaskResponse;
use Illuminate\Http\Request;
use App\Models\ProgressChange;
use App\timatik\BLL\TaskLogic;
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
        return company()->tasks()->where('parent_id', null)->with('children', 'type', 'client')->get();
    }

    public function create(){
        return response()->json([
            'users' => company()->users,
            'clients' => company()->clients,
            'groups' => company()->groups,
            'types' => company()->types()->where('model', 'Task')->get()
        ]);
    }

    public function edit($id){
        $parentOptions = [
            plain_object([
                'id' => null,
                'name' => 'No Parent'
            ])
        ];
        foreach(company()->tasks as $task){
            $parentOptions[] = plain_object([
                'id' => $task->id,
                'name' => $task->name . ' (' . $task->type->name . ')'
            ]);
        }
        return response()->json([
            'users' => company()->users,
            'groups' => company()->groups,
            'types' => company()->types()->where('model', 'Task')->get(),
            'task' => Task::find($id)->load('user', 'group', 'schedule', 'type'),
            'parent' => Task::find($id)->parent,
            'clients' => company()->clients,
            'parent_options' => $parentOptions
        ]);
    }

    public function add($parentId){
        $parent = Task::find($parentId);
        return response()->json([
            'users' => company()->users,
            'groups' => company()->groups,
            'types' => company()->types()->where('model', 'Task')->get(),
            'parent' => $parent,
            'clients' => company()->clients,
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
        $task = (new CreateTaskResponse)->toResponse($request);        
        if($request->user_id){
            $this->subscribeUserToTask($task);
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
        $task = Task::find($id)
            ->load('columns', 'user', 'subscribers', 'children', 'type', 'changes', 'group', 'client', 'schedule', 'files');
        $task->report = $task->runReport();
        return $task;
    }

    public function attachFile($task, $file){
        Task::find($task)->files()->attach($file);
    }

    public function detachFile($task, $file){
        Task::find($task)->files()->detach($file);
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
        (new DeleteTaskResponse)->toResponse($id);
    }
}
