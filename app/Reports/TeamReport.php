<?php
namespace App\Reports;
use App\Repositories\TeamReportRepository;
use App\Models\Task;
class TeamReport extends Report {
    public static $name = "Report Name";
    public function __construct($arg){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new TeamReportRepository(new Task, $arg);
    }

    public function format(){
        return [];
    }

}        
