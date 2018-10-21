<?php
namespace App\Reports;
use App\Repositories\GroupReportRepository;
use App\Models\Group;

class GroupReport extends Report {
    public static $name = "Report Name";
    public function __construct($arg){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new GroupReportRepository(new Group, $arg);
    }

    public function format(){
        return [
            'tasks' => $this->repository->getSpecifiedModel()->recursivGetTasks(),
            'callendar' => (new TaskCalendar)->show(date('F'), $this->repository->getSpecifiedModel()->recursivGetTasks())
        ];
    }

}        
