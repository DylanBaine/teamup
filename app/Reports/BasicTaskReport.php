<?php
namespace App\Reports;
use App\Repositories\BasicTaskReportRepository;
use App\Models\Task;
use Carbon\Carbon;
class BasicTaskReport extends Report {

    public static $name = "Task Report";
    public function __construct($arg = null){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new BasicTaskReportRepository(new Task, $arg);
    }

    protected function format(){
        return[
            'percent' => $this->percents(),
            'days' => $this->days(),
            'changes' => $this->repository->getSpecifiedModel()->changes
        ];
    }

    private function percents(){
        return [
            ['Column', 'Percent'],
            ['In Progress' , $this->repository->percentOfTimeIn('In Progress')],
            ['Back Log' , $this->repository->percentOfTimeIn('Back Log')],
            ['Finished' , $this->repository->percentOfTimeIn('Finished')],
        ];
    }

    private function days(){
        return [
            'existed' => $this->repository->getSpecifiedModel()->created_at->diffInDays(Carbon::now())/$this->repository->getSpecifiedModel()->created_at->diffInSeconds(Carbon::now())*100,
            'in_backlog' => $this->repository->daysInColumn('Back Log'),
            'in_current_column' => $this->repository->daysInCurrentColumn()
        ];
    }


}        
