<?php
namespace App\Reports;
use App\Repositories\SprintReportRepository;
use App\Models\Task;
class SprintReport extends Report {
    
    public static $name = "Sprint Report";
    public function __construct($arg = null){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new SprintReportRepository(new Task, $arg);
    }

    public function format(){
        return [];
    }

}        
