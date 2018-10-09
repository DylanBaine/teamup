<?php
namespace App\timatik\Responses;
use Illuminate\Contracts\Support\Responsable;
use App\Models\ScheduledActivity;
use App\Models\Task;
use App\Models\ProgressChange;
class CreateTaskResponse implements Responsable{

    public function toResponse($request){
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
        $t->client_id = $request->client_id;
        $t->column_id = $parent && $parent->columns()->count() ?
        $parent->columns()->first()->id :
        null;
        $t->report = 0;
        $t->start_date = $request->start_date ? carbon_format($request->start_date) : null;
        $t->end_date = $request->end_date ? carbon_format($request->end_date) : null;
        $t->save();
        $t->linkReport();
        if ($t->type->name === 'Sprint') {
            $t->createDefaultSettings();
        }
        if($t->type->name == 'Reoccurring'){
            $this->scheduleReoccurringActivity(json_decode($request->schedule), $t->id);
        }
        if($t->column){
            ProgressChange::create([
                'task_id' => $t->id,
                'column_id' => $t->column->id,
                'user_id' => user('id'),
                'duration_in_seconds' => 0
                ]);
        }
        return $t;
    }

    private function scheduleReoccurringActivity($schedule, $taskId){
        ScheduledActivity::create([
            'type' => $schedule->type,
            'time' => $schedule->time,
            'day' => $schedule->day,
            'week' => $schedule->week,
            'schedulable_type' => 'Task',
            'schedulable_id' => $taskId
        ]);
    }

}