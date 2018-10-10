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
        $this->deleteAttachments($task);
        $task->delete();
    }

    private function deleteAttachments($task){
        foreach($task->subscribers as $sub){
            $sub->delete();
        }

        foreach(ProgressChange::where('task_id', $task->id) as $progChange){
            $progChange->delete();
        }
        $schedule = ScheduledActivity::where('schedulable_type', 'Task')->where('schedulable_id', $task->id)->first();
        if($schedule){
            $schedule->delete();
        }
    }

}