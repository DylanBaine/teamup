<?php
namespace App\timatik\Responses;
use Illuminate\Contracts\Support\Responsable;
use App\Models\ScheduledActivity;
use App\Models\Task;
use App\Models\ProgressChange;
class DeleteTaskResponse implements Responsable{

    public function toResponse($id){
        $task = Task::find($id);
        if ($task->parent_id == null || $task->parent_id == 0) {
            foreach ($task->children()->get() as $child) {
                $parentName = $task->name;
                $child->parent_id = null;
                $child->description .= "<p>(once a child to $parentName)</p>";
                $child->save();
            }
        }
        $task->deleteAttachments();
        $task->delete();
    }

}