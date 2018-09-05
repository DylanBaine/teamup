<?php
namespace App\Reports;
use App\Repositories\ProjectReportRepository;
use App\Models\Task;
class ProjectReport extends Report {
    public static $name = "Report Name";
    public function __construct($arg){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new ProjectReportRepository(new Task, $arg);
    }

    public function format(){
        return [
            'sprints' => $this->repository->collectAllChildrenOfTaskByType('sprint')->count(),
            'task_breakdown' => $this->getPercentOfTasksThatAreFinished()
        ];
    }

    public function getPercentOfTasksThatAreFinished(){
        $finished = collect([]);
        $in_progress = collect([]);
        $back_log = collect([]);
        $children = $this->repository->recursivGetChildrenOfTaskByType($this->repository->getSpecifiedModel(),'task');
        foreach($children as $child){
            $colName = $child->column->value;
            if($colName == 'Finished'){
                $finished->push($child);
            }elseif($colName == 'In Progress'){
                $in_progress->push($child);
            }else{
                $back_log->push($child);
            }
        }
        return [
            ['Status', 'Percent Finished'],
            ['In Progress', $in_progress->count()],
            ['Back log', $back_log->count()],
            ['Finished', $finished->count()]
        ];
    }

}        
